<?php

namespace App\Http\Controllers;

use App\Models\Discounts;
use App\Models\BusinessLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExploreDealsController extends Controller
{
    public function index(Request $request)
    {
        // 1. Base query: active, not expired
        $query = Discounts::with(['business', 'validLocations'])
            ->where('status', 'active')
            ->where('end_date', '>=', now());

        // 2. Text Search (title, promo code, business name, description)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('promo_code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('business', function ($b) use ($search) {
                        $b->where('business_name', 'like', "%{$search}%");
                    });
            });
        }

        // 3. Location filters via validLocations (mapping table)
        if ($request->filled('country')) {
            $query->whereHas('validLocations', function ($q) use ($request) {
                $q->where('country', $request->country);
            });
        }

        if ($request->filled('state')) {
            $query->whereHas('validLocations', function ($q) use ($request) {
                $q->where('state', $request->state);
            });
        }

        if ($request->filled('city')) {
            $query->whereHas('validLocations', function ($q) use ($request) {
                $q->where('city', $request->city);
            });
        }

        // 4. Fetch data with pagination (12 per page)
        $deals = $query->orderBy('created_at', 'desc')->paginate(12);

        // 5. AJAX response (used by exploredeals-enhanced.blade.php)
        if ($request->ajax()) {
            $dealsData = $deals->getCollection()->transform(function ($deal) {
                // Map locations coming from validLocations pivot
                $locations = $deal->validLocations->map(function ($loc) {
                    return [
                        'name'    => $loc->branch_name ?? $loc->name ?? 'Branch',
                        'address' => $loc->address ?? '',
                        'city'    => $loc->city ?? '',
                        'state'   => $loc->state ?? '',
                        'country' => $loc->country ?? '',
                    ];
                })->values()->toArray();

                // return [
                //     'id'              => $deal->id,
                //     'title'           => $deal->title,
                //     'description'     => $deal->description,
                //     'terms'           => $deal->terms,
                //     // Card logo (business logo)
                //     'logo_url'        => $deal->business?->logo_url
                //         ? Storage::url($deal->business->logo_url)
                //         : null,
                //     // Modal main image (deal image)
                //     'deal_image_url'  => $deal->image_url
                //         ? Storage::url($deal->image_url)
                //         : null,
                //     'discount_display' => $deal->discount_type === 'percentage'
                //         ? $deal->discount_value . '% OFF'
                //         : '₹' . number_format($deal->discount_value) . ' OFF',
                //     'business_name'   => $deal->business->business_name ?? 'Unknown',
                //     'promo_code'      => $deal->promo_code,
                //     'start_date'      => \Carbon\Carbon::parse($deal->start_date)->format('d M, Y'),
                //     'end_date'        => \Carbon\Carbon::parse($deal->end_date)->format('d M, Y'),
                //     'min_purchase'    => $deal->min_purchase,
                //     'location_count'  => count($locations),
                //     'locations'       => $locations,
                // ];
                
                return [
    'id'              => $deal->id,
    'title'           => $deal->title,
    'description'     => $deal->description ?? null,
    'business_description' => $deal->business->description ?? null, // ← ADD THIS
    'terms'           => $deal->terms,
    'logo_url'        => $deal->business?->logo_url
        ? Storage::url($deal->business->logo_url)
        : null,
    'deal_image_url'  => $deal->image_url
        ? Storage::url($deal->image_url)
        : null,
    'discount_display' => $deal->discount_type === 'percentage'
        ? $deal->discount_value . '% OFF'
        : '₹' . number_format($deal->discount_value) . ' OFF',
    'business_name'   => $deal->business->business_name ?? 'Unknown',
    'promo_code'      => $deal->promo_code,
    'start_date'      => \Carbon\Carbon::parse($deal->start_date)->format('d M, Y'),
    'end_date'        => \Carbon\Carbon::parse($deal->end_date)->format('d M, Y'),
    'min_purchase'    => $deal->min_purchase,
    'location_count'  => count($locations),
    'locations'       => $locations,
];

            });

            return response()->json([
                'deals'      => $dealsData,
                'pagination' => (string) $deals->links(),
            ]);
        }

        // 6. Initial page load
        $countries = BusinessLocation::select('country')
            ->distinct()
            ->orderBy('country')
            ->pluck('country');

        return view('exploredeals', compact('deals', 'countries'));
    }

    public function getStates(Request $request)
    {
        $states = BusinessLocation::where('country', $request->country)
            ->select('state')
            ->distinct()
            ->orderBy('state')
            ->pluck('state');

        return response()->json($states);
    }

    public function getCities(Request $request)
    {
        $cities = BusinessLocation::where('state', $request->state)
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        return response()->json($cities);
    }
}
