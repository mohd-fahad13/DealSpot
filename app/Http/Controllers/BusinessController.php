<?php

namespace App\Http\Controllers;

use App\Models\Businesses as Business;
use App\Models\BusinessLocation;
use App\Models\Category;
use App\Models\BusinessOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /business
     * Route: business.showAll
     */
    public function index()
    {
        $ownerId = session('owner_id');
        
        if (!$ownerId) {
            return redirect()->route('owner.login')
                ->with('error', 'Please login to view your businesses.');
        }

        $businesses = Business::where('owner_id', $ownerId)
            ->with(['locations', 'category'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('business.showAll', compact('businesses'));
    }

    /**
     * Show the form for creating a new resource.
     * GET /business/create
     * Route: business.create
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get(['id', 'name']);
        return view('business.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * POST /business
     * Route: business.store
     */
    public function store(Request $request)
    {
        $rules = [
            'business_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'category_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'logo_file' => 'required|image|mimes:jpg,jpeg,png|max:4096',
            'status' => 'required|in:active,inactive',
            'locations' => 'required|array|min:1',
            'locations.*.branch_name' => 'required|string|max:255',
            'locations.*.phone' => 'nullable|string|max:255',
            'locations.*.email' => 'nullable|email|max:255',
            'locations.*.address' => 'required|string|max:255',
            'locations.*.country' => 'required|string|max:255',
            'locations.*.state' => 'required|string|max:255',
            'locations.*.city' => 'required|string|max:255',
            'locations.*.postal_code' => 'required|string|max:50',
            'locations.*.is_primary' => 'nullable|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $ownerId = $request->input('owner_id') ?? session('owner_id') ?? null;
        
        DB::beginTransaction();
        try {
            $logoPath = null;
            if ($request->hasFile('logo_file')) {
                $logoPath = $request->file('logo_file')->store('business_logos', 'public');
            }

            $business = Business::create([
                'owner_id' => $ownerId,
                'business_name' => $request->business_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'logo_url' => $logoPath,
                'is_verified' => 0,
                'status' => $request->status,
            ]);

            $locations = $request->input('locations', []);
            $foundPrimary = false;
            
            foreach ($locations as $loc) {
                $isPrimary = isset($loc['is_primary']) && $loc['is_primary'] ? 1 : 0;
                
                if ($isPrimary && !$foundPrimary) {
                    $foundPrimary = true;
                } else {
                    $isPrimary = 0;
                }

                BusinessLocation::create([
                    'business_id' => $business->id,
                    'branch_name' => $loc['branch_name'],
                    'phone' => $loc['phone'] ?? null,
                    'email' => $loc['email'] ?? null,
                    'address' => $loc['address'],
                    'country' => $loc['country'],
                    'state' => $loc['state'],
                    'city' => $loc['city'],
                    'postal_code' => $loc['postal_code'],
                    'is_primary' => $isPrimary,
                ]);
            }

            DB::commit();
            
            return redirect()->route('business.showAll')
                ->with('success', 'Business and locations created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     * GET /business/{business}
     * Route: business.show
     * ✅ FIXED: Use Business $business for model binding
     */
    public function show(Business $business)
    {
        // Check authorization
        if ($business->owner_id != session('owner_id')) {
            return redirect()->route('business.showAll')
                ->with('error', 'Unauthorized access.');
        }

        $business->load(['locations', 'category']);
        
        return view('business.show', compact('business'));
    }

    /**
     * Show the form for editing the specified resource.
     * GET /business/{business}/edit
     * Route: business.edit
     * FIXED: Use Business $business for model binding
     */
    public function edit(Business $business)
    {
        // Check authorization
        if ($business->owner_id != session('owner_id')) {
            return redirect()->route('business.showAll')
                ->with('error', 'Unauthorized access.');
        }

        $business->load(['locations', 'category']);
        $categories = Category::orderBy('name')->get(['id', 'name']);
        
        return view('business.form', compact('business', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /business/{business}
     * Route: business.update
     * FIXED: Use Business $business for model binding
     */
    public function update(Request $request, Business $business)
    {
        // Check authorization
        if ($business->owner_id != session('owner_id')) {
            return redirect()->route('business.showAll')
                ->with('error', 'Unauthorized access.');
        }

        $rules = [
            'business_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'category_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'logo_file' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'status' => 'required|in:active,inactive',
            'locations' => 'required|array|min:1',
            'locations.*.id' => 'nullable|integer|exists:business_locations,id',
            'locations.*.branch_name' => 'required|string|max:255',
            'locations.*.phone' => 'nullable|string|max:255',
            'locations.*.email' => 'nullable|email|max:255',
            'locations.*.address' => 'required|string|max:255',
            'locations.*.country' => 'required|string|max:255',
            'locations.*.state' => 'required|string|max:255',
            'locations.*.city' => 'required|string|max:255',
            'locations.*.postal_code' => 'required|string|max:50',
            'locations.*.is_primary' => 'nullable|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Update logo if provided
            $logoPath = $business->logo_url;
            if ($request->hasFile('logo_file')) {
                if ($business->logo_url && Storage::disk('public')->exists($business->logo_url)) {
                    Storage::disk('public')->delete($business->logo_url);
                }
                $logoPath = $request->file('logo_file')->store('business_logos', 'public');
            }

            // Update business
            $business->update([
                'business_name' => $request->business_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'logo_url' => $logoPath,
                'status' => $request->status,
            ]);

            // Update/Create locations
            $locations = $request->input('locations', []);
            $foundPrimary = false;
            $existingLocationIds = [];

            foreach ($locations as $loc) {
                $isPrimary = isset($loc['is_primary']) && $loc['is_primary'] ? 1 : 0;
                
                if ($isPrimary && !$foundPrimary) {
                    $foundPrimary = true;
                } else {
                    $isPrimary = 0;
                }

                if (isset($loc['id']) && $loc['id']) {
                    // Update existing location
                    BusinessLocation::where('id', $loc['id'])
                        ->where('business_id', $business->id)
                        ->update([
                            'branch_name' => $loc['branch_name'],
                            'phone' => $loc['phone'] ?? null,
                            'email' => $loc['email'] ?? null,
                            'address' => $loc['address'],
                            'country' => $loc['country'],
                            'state' => $loc['state'],
                            'city' => $loc['city'],
                            'postal_code' => $loc['postal_code'],
                            'is_primary' => $isPrimary,
                        ]);
                    $existingLocationIds[] = $loc['id'];
                } else {
                    // Create new location
                    $newLoc = BusinessLocation::create([
                        'business_id' => $business->id,
                        'branch_name' => $loc['branch_name'],
                        'phone' => $loc['phone'] ?? null,
                        'email' => $loc['email'] ?? null,
                        'address' => $loc['address'],
                        'country' => $loc['country'],
                        'state' => $loc['state'],
                        'city' => $loc['city'],
                        'postal_code' => $loc['postal_code'],
                        'is_primary' => $isPrimary,
                    ]);
                    $existingLocationIds[] = $newLoc->id;
                }
            }

            // Delete removed locations
            BusinessLocation::where('business_id', $business->id)
                ->whereNotIn('id', $existingLocationIds)
                ->delete();

            DB::commit();
            
            return redirect()->route('business.showAll')
                ->with('success', 'Business updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /business/{business}
     * Route: business.destroy
     * FIXED: Use Business $business for model binding
     */
    public function destroy(Business $business)
    {
        // Check authorization
        if ($business->owner_id != session('owner_id')) {
            return redirect()->route('business.showAll')
                ->with('error', 'Unauthorized access.');
        }

        DB::beginTransaction();
        try {
            // Delete logo if exists
            if ($business->logo_url && Storage::disk('public')->exists($business->logo_url)) {
                Storage::disk('public')->delete($business->logo_url);
            }

            // Delete all related locations
            $business->locations()->delete();

            // Delete business record
            $business->delete();

            DB::commit();
            
            return redirect()->route('business.showAll')
                ->with('success', 'Business deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('business.showAll')
                ->with('error', 'Failed to delete business. Please try again.');
        }
    }

    /**
     * Get all categories (API endpoint)
     * GET /show-category
     * Route: show-category
     */
    public function showCategory()
    {
        $owner = session()->has('owner_id')
            ? BusinessOwner::find(session('owner_id'))
            : null;

        $categories = Category::orderBy('name')->get(['id', 'name']);

        return response()->json([
            'owner' => $owner,
            'categories' => $categories
        ]);
    }
}
