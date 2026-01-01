<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discounts;
use App\Models\Businesses;
use App\Models\BusinessLocation; 
use App\Models\MappingBusinessDiscountLocation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class DealsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ownerId = session('owner_id'); // fallback for testing
        
        if (!$ownerId) {
            return redirect()->route('owner.login')
                ->with('error', 'Please login to view your deals.');
        }

        // Get owner's businesses first
        $businessIds = Businesses::where('owner_id', $ownerId)
                                ->where('status', 'active')
                                ->pluck('id'); // Get only business IDs

        // Get deals for those businesses with business info
        $deals = Discounts::whereIn('business_id', $businessIds)
                        ->with('business') // Eager load business relationship
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('deals.showAll', compact('deals'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $ownerId = session('owner_id');
        
        // If business_id is passed in query, we can pre-select it
        $preselectedBusinessId = $request->query('business_id');

        $businesses = Businesses::where('owner_id', $ownerId)
            ->where('status', 'active')
            ->select('id', 'business_name')
            ->orderBy('business_name')
            ->get();

        return view('deals.form', compact('businesses', 'preselectedBusinessId'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'business_id'     => ['required', 'integer', 'exists:businesses,id'],
            'title'           => ['required', 'string', 'max:255'],
            'description'     => ['nullable', 'string'],
            'discount_value'  => ['required', 'numeric', 'min:0'],
            'discount_type'   => ['required', 'in:percentage,amount'],
            'terms'           => ['nullable', 'string'],
            'start_date'      => ['required', 'date'],
            'end_date'        => ['required', 'date', 'after_or_equal:start_date'],
            'min_purchase'    => ['nullable', 'numeric', 'min:0'],
            'promo_code'      => ['nullable', 'string', 'max:255'],
            'status'          => ['required', 'in:active,inactive,expired'],
            'image'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],      
            'location_ids'    => ['nullable', 'array'],
            'location_ids.*'  => ['integer', 'exists:business_locations,id'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // upload banner image if provided
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('discounts', 'public');
            }

            // create discount row
            $discount = Discounts::create([
                // 'business_id'    => 6, // TEMP: replace with real id
                'business_id'    => $request->business_id,
                'title'          => $request->title,
                'description'    => $request->description,
                'discount_value' => $request->discount_value,
                'discount_type'  => $request->discount_type,
                'terms'          => $request->terms,
                'start_date'     => $request->start_date,
                'end_date'       => $request->end_date,
                'min_purchase'   => $request->min_purchase,
                'promo_code'     => $request->promo_code,
                'image_url'      => $imagePath,
                'status'         => $request->status, // enum: active/inactive/expired
            ]);

            // auto-attach category from related business into discount_categories
            $business = $discount->business; // uses Discount::business() relation
            if ($business && $business->category_id) {
                // writes rows into discount_categories (discount_id, category_id)
                $discount->categories()->sync([$business->category_id]);
            }

            // ✅ STORE MAPPING: Save business_id, discount_id, location_id with timestamps
            $locationIds = $request->input('location_ids', []);
            if (!empty($locationIds)) {
                $mappings = [];
                foreach ($locationIds as $locationId) {
                    $mappings[] = [
                        'business_id' => $request->business_id,
                        'discount_id' => $discount->id,
                        'location_id' => $locationId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                MappingBusinessDiscountLocation::insert($mappings);
            }

            DB::commit();

            return redirect()
                ->route('dashboard')
                ->with('success', 'Deal created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withErrors(['error' => 'Unable to save deal.'])
                ->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $deal = Discounts::with('business')->findOrFail($id);
        
        // Authorization check
        $ownerId = session('owner_id');
        if ($deal->business->owner_id != $ownerId) {
            return redirect()->route('deals.showAll')->with('error', 'Unauthorized access.');
        }

        return view('deals.show', compact('deal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    //     $deal = Discounts::findOrFail($id);
    //     $ownerId = session('owner_id');

    //     // Verify ownership
    //     if ($deal->business->owner_id != $ownerId) {
    //         return redirect()->route('deals.showAll')->with('error', 'Unauthorized access.');
    //     }

    //     $businesses = Businesses::where('owner_id', $ownerId)
    //         ->where('status', 'active')
    //         ->select('id', 'business_name')
    //         ->orderBy('business_name')
    //         ->get();

    //     return view('deals.form', compact('deal', 'businesses'));
    // }
    public function edit(string $id)
{
    $deal = Discounts::findOrFail($id);
    $ownerId = session('owner_id');
    
    // Verify ownership
    if ($deal->business->owner_id != $ownerId) {
        return redirect()->route('deals.showAll')->with('error', 'Unauthorized access.');
    }

    $businesses = Businesses::where('owner_id', $ownerId)
        ->where('status', 'active')
        ->select('id', 'business_name')
        ->orderBy('business_name')
        ->get();

    // ✅ NEW: Get selected location IDs from mapping table
    $selectedLocationIds = MappingBusinessDiscountLocation::where('discount_id', $id)
        ->pluck('location_id')
        ->toArray();

    return view('deals.form', compact('deal', 'businesses', 'selectedLocationIds'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $deal = Discounts::findOrFail($id);
        
        // Verify ownership
        $ownerId = session('owner_id');
        if ($deal->business->owner_id != $ownerId) {
            return redirect()->route('deals.showAll')->with('error', 'Unauthorized access.');
        }

        $rules = [
            'business_id'    => ['required', 'integer', 'exists:businesses,id'],
            'title'          => ['required', 'string', 'max:255'],
            'description'    => ['nullable', 'string'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'discount_type'  => ['required', 'in:percentage,amount'],
            'terms'          => ['nullable', 'string'],
            'start_date'     => ['required', 'date'],
            'end_date'       => ['required', 'date', 'after_or_equal:start_date'],
            'min_purchase'   => ['nullable', 'numeric', 'min:0'],
            'promo_code'     => ['nullable', 'string', 'max:255'],
            'status'         => ['required', 'in:active,inactive,expired'],
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'location_ids'   => ['nullable', 'array'],
            'location_ids.*' => ['integer', 'exists:business_locations,id'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $imagePath = $deal->image_url;
            if ($request->hasFile('image')) {
                // Delete old image
                if ($deal->image_url && Storage::disk('public')->exists($deal->image_url)) {
                    Storage::disk('public')->delete($deal->image_url);
                }
                $imagePath = $request->file('image')->store('discounts', 'public');
            }

            $deal->update([
                'business_id'    => $request->business_id,
                'title'          => $request->title,
                'description'    => $request->description,
                'discount_value' => $request->discount_value,
                'discount_type'  => $request->discount_type,
                'terms'          => $request->terms,
                'start_date'     => $request->start_date,
                'end_date'       => $request->end_date,
                'min_purchase'   => $request->min_purchase,
                'promo_code'     => $request->promo_code,
                'image_url'      => $imagePath,
                'status'         => $request->status,
            ]);

            // Sync categories logic if business changed (optional)
             $business = $deal->business; 
            if ($business && $business->category_id) {
                $deal->categories()->sync([$business->category_id]);
            }

            // ✅ NEW: Update mapping table - DELETE old, INSERT new
            $locationIds = $request->input('location_ids', []);
            
            // Delete old mappings for this discount
            MappingBusinessDiscountLocation::where('discount_id', $id)->delete();
            
            // Insert new mappings if locations selected
            if (!empty($locationIds)) {
                $mappings = [];
                foreach ($locationIds as $locationId) {
                    $mappings[] = [
                        'business_id' => $request->business_id,
                        'discount_id' => $deal->id,
                        'location_id' => $locationId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                MappingBusinessDiscountLocation::insert($mappings);
            }

            DB::commit();
            return redirect()->route('deals.showAll')->with('success', 'Deal updated successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Unable to update deal: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $deal = Discounts::findOrFail($id);
        $ownerId = session('owner_id');

        if ($deal->business->owner_id != $ownerId) {
            return back()->with('error', 'Unauthorized access.');
        }

        if ($deal->image_url && Storage::disk('public')->exists($deal->image_url)) {
            Storage::disk('public')->delete($deal->image_url);
        }

        $deal->delete();
        return redirect()->route('deals.showAll')->with('success', 'Deal deleted successfully.');
    }

    /**
     * Display a listing of businesses for the logged-in owner (AJAX).
     */    
    public function businessesList()
    {
        $ownerId = session('owner_id'); // Your exact logic
        
        if (!$ownerId) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to view your businesses.'
            ], 401);
        }

        $businesses = Businesses::where('owner_id', $ownerId)
                            ->where('status', 'active') // Only active businesses
                            ->select('id', 'business_name as name') // Use your exact column
                            ->orderBy('business_name', 'asc')
                            ->get();
        // dd($businesses);

        return response()->json([
            'success' => true,
            'businesses' => $businesses
        ]);
    }

    /**
 * AJAX: Fetch locations for a selected business.
 */
// public function locationsList(Request $request)
// {
//     $ownerId = session('owner_id');
//     $businessId = $request->query('business_id');

//     if (!$businessId) {
//         return response()->json(['locations' => []]);
//     }

//     // Security check: Ensure business belongs to logged-in owner
//     $exists = \App\Models\Business::where('id', $businessId)
//         ->where('owner_id', $ownerId)
//         ->exists();

//     if (!$exists) {
//         return response()->json(['locations' => []], 403);
//     }

//     // Fetch locations
//     $locations = \App\Models\BusinessLocation::where('business_id', $businessId)
//         ->select('id', 'location_name')
//         ->orderBy('location_name')
//         ->get();

//     return response()->json(['locations' => $locations]);
// }
    // public function locationsList(Request $request)
    // {
    //     // 1. Get Owner ID (Handle both session and Auth)
    //     $ownerId = session('owner_id') ?? auth()->id(); 

    //     // 2. Get Business ID
    //     $businessId = $request->query('business_id');

    //     if (!$businessId || !$ownerId) {
    //         return response()->json(['locations' => []]);
    //     }

    //     // 3. Security Check (Bypass for testing if needed, but keep for production)
    //     // Ensure Business Model is imported: use App\Models\Business;
    //     $exists = \App\Models\Businesses::where('id', $businessId)
    //         ->where('owner_id', $ownerId)
    //         ->exists();

    //     // Debugging: If this fails, check your database owner_id vs session owner_id
    //     if (!$exists) {
    //         // Return empty for now to avoid 403 error on frontend during dev
    //         // return response()->json(['locations' => [], 'error' => 'Unauthorized'], 403);
    //          return response()->json(['locations' => []]); 
    //     }

    //     // 4. Fetch Locations
    //     // Ensure BusinessLocation Model is imported: use App\Models\BusinessLocation;
    //     $locations = \App\Models\BusinessLocation::where('business_id', $businessId)
    //         ->select('id', 'location_name')
    //         ->orderBy('location_name')
    //         ->get();

    //     return response()->json(['locations' => $locations]);
    // }
/**
 * AJAX: Fetch locations for a selected business.
 */
public function locationsList(Request $request)
{
    $businessId = $request->query('business_id');

    if (!$businessId) {
        return response()->json(['locations' => []]);
    }

    // Fetch locations for this business
    $locations = BusinessLocation::where('business_id', $businessId)
        ->select('id', 'branch_name')
        ->orderBy('branch_name')
        ->get();

    return response()->json(['locations' => $locations]);
}



}
