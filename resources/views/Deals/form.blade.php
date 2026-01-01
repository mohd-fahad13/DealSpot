@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    :root {
        --g1: #ec4899;
        --g2: #8b5cf6;
        --g3: #22c55e;
        --card-bg: #ffffff;
        --muted: #6b7280;
    }

    body {
        background: radial-gradient(circle at top, #0f172a 0, #020617 45%, #020617 100%);
        color: #0f172a;
    }

    .deal-card {
        max-width: 1100px;
        margin: 3rem auto;
        border-radius: 1.25rem;
        overflow: hidden;
        background: rgba(15,23,42,0.96);
        box-shadow: 0 30px 80px rgba(15,23,42,0.8);
        border: 1px solid rgba(148,163,184,0.3);
    }

    .deal-hero {
        padding: 2rem 2.5rem 1.5rem;
        background: radial-gradient(circle at top left, var(--g1), transparent 55%),
                    radial-gradient(circle at top right, var(--g2), transparent 55%);
        position: relative;
        color: #f9fafb;
    }
    .deal-hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at bottom, rgba(34,197,94,0.18), transparent 65%);
        opacity: 0.9;
        mix-blend-mode: screen;
        pointer-events: none;
    }
    .deal-hero-inner {
        position: relative;
        z-index: 1;
    }

    .deal-badge {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .4rem .9rem;
        border-radius: 999px;
        background: rgba(15,23,42,0.45);
        border: 1px solid rgba(248,250,252,0.24);
        font-size: .8rem;
    }

    .deal-body {
        padding: 2rem 2.5rem 2.2rem;
        background: radial-gradient(circle at top left, rgba(236,72,153,0.12), transparent 55%),
                    radial-gradient(circle at bottom right, rgba(56,189,248,0.1), transparent 60%),
                    linear-gradient(135deg, #020617, #020617);
    }

    .form-panel {
        background: rgba(15,23,42,0.85);
        border-radius: 1rem;
        padding: 1.25rem 1.5rem;
        border: 1px solid rgba(148,163,184,0.35);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
    }

    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #e5e7eb;
    }
    .helper {
        font-size: .85rem;
        color: var(--muted);
    }

    .form-label {
        font-size: .85rem;
        color: #e5e7eb;
    }
    .form-control,
    .form-select {
        background-color: rgba(15,23,42,0.85);
        border-radius: .6rem;
        border: 1px solid rgba(148,163,184,0.45);
        color: #e5e7eb;
        font-size: .9rem;
    }
    .form-control:focus,
    .form-select:focus {
        background-color: rgba(15,23,42,0.98);
        border-color: #6366f1;
        box-shadow: 0 0 0 1px rgba(129,140,248,0.4);
        color: #f9fafb;
    }
    .form-control::placeholder {
        color: #64748b;
    }

    /* CTA button */
    .btn-gradient {
        background-image: linear-gradient(120deg, var(--g1), var(--g2));
        color: #f9fafb;
        border: none;
        border-radius: 999px;
        padding: .7rem 1.7rem;
        font-weight: 600;
        letter-spacing: .02em;
        box-shadow: 0 18px 40px rgba(129,140,248,0.4);
        position: relative;
        overflow: hidden;
        transition: transform .15s ease-out, box-shadow .15s ease-out;
    }
    .btn-gradient::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top left, rgba(248,250,252,0.35), transparent 55%);
        opacity: 0;
        transition: opacity .2s ease-out;
    }
    .btn-gradient:hover {
        transform: translateY(-1px) scale(1.01);
        box-shadow: 0 22px 55px rgba(129,140,248,0.55);
    }
    .btn-gradient:hover::after {
        opacity: 1;
    }

    .badge-soft {
        background: rgba(34,197,94,0.15);
        color: #bbf7d0;
        border-radius: 999px;
        padding: .25rem .7rem;
        font-size: .75rem;
    }

    /* Live preview card */
    .preview-card {
        background: radial-gradient(circle at top, rgba(56,189,248,0.18), transparent 60%),
                    radial-gradient(circle at bottom, rgba(236,72,153,0.22), transparent 60%),
                    rgba(15,23,42,0.9);
        border-radius: 1rem;
        padding: 1.4rem 1.5rem 1.6rem;
        border: 1px solid rgba(148,163,184,0.5);
        color: #f9fafb;
        position: relative;
        overflow: hidden;
    }
    .preview-glow {
        position: absolute;
        inset: -40%;
        background: radial-gradient(circle at center, rgba(129,140,248,0.35), transparent 60%);
        opacity: 0;
        transition: opacity .35s ease-out;
    }
    .preview-inner {
        position: relative;
        z-index: 1;
    }
    .preview-card:hover .preview-glow {
        opacity: 1;
    }

    .preview-title {
        font-weight: 700;
        font-size: 1.05rem;
    }
    .preview-meta {
        font-size: .8rem;
        color: #cbd5f5;
    }
    .preview-discount {
        font-size: 2.1rem;
        font-weight: 800;
        letter-spacing: .04em;
        background: linear-gradient(120deg, #f97316, #facc15, #22c55e);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    /* Layout */
    @media (min-width: 992px) {
        .deal-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(0, 1fr);
            gap: 1.5rem;
            align-items: flex-start;
        }
    }

    @media (max-width: 991.98px) {
        .deal-card {
            margin: 1.5rem 1rem;
        }
        .deal-body {
            padding-inline: 1.25rem;
        }
    }

    /* subtle fade-in */
    .fade-in-up {
        opacity: 0;
        transform: translateY(12px);
        animation: fadeInUp .6s ease-out forwards;
    }
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="deal-card fade-in-up">
    <div class="deal-hero">
        <div class="deal-hero-inner d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <div class="deal-badge mb-2">
                    <i class="bi bi-stars text-warning"></i>
                    <span>Premium Deal Creation</span>
                </div>
                <h2 class="mb-1">Create a New Deal</h2>
                <p class="mb-0 helper text-slate-50" style="color:#ffffff;">
                    Showcase your best offer to customers with a rich, eye-catching card.
                </p>
            </div>
            <div class="text-end">
                <span class="badge-soft d-inline-flex align-items-center gap-1 mb-1 border border-slate-700">
                    <i class="bi bi-lightning-charge-fill"></i> Live preview
                </span>
                <!-- <div class="helper">Deals table: <code>discounts</code></div> -->
            </div>
        </div>
    </div>

    <div class="deal-body">
        <form action="{{ isset($deal) ? route('deals.update', $deal->id) : route('deals.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($deal))
                @method('PUT')
            @endif

            <div class="deal-grid">
                {{-- Left: form --}}
                <div class="form-panel mb-3 mb-lg-0">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="section-title">Deal details</div>
                            <div class="helper">Fill in all information about this discount.</div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control"
                                   placeholder="Flat 25% off on all pizzas"
                                   value="{{ old('title', isset($deal) ? $deal->title : '') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Business <span class="text-danger">*</span></label>
                            <select name="business_id" class="form-select" required id="businessSelect">
                                <option value="">Loading businesses...</option>
                            </select>
                            <small class="helper">Select business this deal belongs to.</small>
                        </div>

                        {{-- ✅ NEW LOCATIONS FIELD (Full Width) --}}
<div class="col-12">
    <label class="form-label">Locations <span class="text-muted small">(Select business first)</span></label>
    
    <div id="locationsContainer" 
         class="form-panel" 
         style="padding: 1rem; max-height: 250px; overflow-y: auto; background: rgba(15,23,42,0.6); border: 1px solid rgba(148,163,184,0.3);">
        
        <p class="helper mb-0" id="locationsHint">
            <i class="bi bi-shop me-1"></i> Select a business to load available locations.
        </p>

    </div>
    
    @error('location_ids')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>



                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" class="form-control"
                                      placeholder="Describe what is included, timing, and other key highlights.">{{ old('description', isset($deal) ? $deal->description : '') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Discount value <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="discount_value" class="form-control"
                                       step="0.01" min="0"
                                       value="{{ old('discount_value', isset($deal) ? $deal->discount_value : '') }}" required>
                                <select name="discount_type" class="form-select" required>
                                    <option value="percentage" {{ old('discount_type', isset($deal) ? $deal->discount_type : '') === 'percentage' ? 'selected' : '' }}>%</option>
                                    <option value="amount" {{ old('discount_type', isset($deal) ? $deal->discount_type : '') === 'amount' ? 'selected' : '' }}>₹</option>
                                </select>
                            </div>
                            <small class="helper">Choose percentage or fixed amount.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Minimum purchase</label>
                            <input type="number" name="min_purchase" class="form-control"
                                   step="0.01" min="0"
                                   value="{{ old('min_purchase', isset($deal) ? $deal->min_purchase : '') }}">
                            <small class="helper">Optional. Leave empty for no minimum.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Start date <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" class="form-control"
                                   value="{{ old('start_date', isset($deal) ? $deal->start_date : '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">End date <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" class="form-control"
                                   value="{{ old('end_date', isset($deal) ? $deal->end_date : '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Promo code</label>
                            <input type="text" name="promo_code" class="form-control"
                                   placeholder="DEAL2025"
                                   value="{{ old('promo_code', isset($deal) ? $deal->promo_code : '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="">Select status</option>
                                <option value="active" {{ old('status', isset($deal) ? $deal->status : 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', isset($deal) ? $deal->status : '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Banner image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @if(isset($deal) && $deal->image_url)
                                <div class="mt-2 p-2 bg-slate-800 rounded-lg">
                                    <img src="{{ Storage::url($deal->image_url) }}" class="img-fluid rounded" style="max-height: 80px;">
                                    <small class="text-slate-400 d-block mt-1">Current image</small>
                                </div>
                            @endif

                            <small class="helper">Recommended 1200×600, JPG/PNG, max 2MB.</small>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <strong>Fix the following:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn btn-gradient">
                            <i class="bi bi-check2-circle me-1"></i> {{ isset($deal) ? 'Update Deal' : 'Publish Deal' }}
                        </button>
                    </div>
                </div>

                {{-- Right: live preview / tips --}}
                <div class="d-flex flex-column gap-3">
                    <div class="preview-card" id="dealPreview">
                        <div class="preview-glow"></div>
                        <div class="preview-inner">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="preview-title" id="pvTitle">Your deal title</div>
                                    <div class="preview-meta" id="pvDates">Start – End dates</div>
                                </div>
                                <span class="badge-soft" id="pvStatusBadge">Active</span>
                            </div>
                            <div class="preview-discount mb-2" id="pvValue">0% OFF</div>
                            <p class="mb-2 helper text-slate-200" id="pvDesc">
                                Short description of the deal will appear here.
                            </p>
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <span class="badge bg-slate-800 border border-slate-600" id="pvType">
                                    Percentage
                                </span>
                                <span class="badge bg-slate-800 border border-slate-600" id="pvMin">
                                    No minimum
                                </span>
                                <span class="badge bg-slate-800 border border-slate-600" id="pvCode">
                                    No code
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-panel">
                        <div class="section-title mb-2">Design tips</div>
                        <ul class="helper mb-0">
                            <li>Use short, powerful titles (under 60 characters).</li>
                            <li>Set realistic start/end dates so customers trust the offer.</li>
                            <li>Upload a bright banner image that matches your brand.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>
</d iv>
<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->
<!-- <script>
// simple live preview
    $(document).ready(function () {
        // Load businesses automatically on page load
        $.ajax({
            url: "{{ route('show-businesses-list') }}",
            type: "GET",
            success: function (res) {
                let select = $("#businessSelect");
                select.empty();
                select.append('<option value="">Select a business...</option>');

                if (res.success && res.businesses && res.businesses.length > 0) {
                    $.each(res.businesses, function (index, business) {
                        select.append(`<option value="${business.id}">${business.name}</option>`);
                    });
                } else {
                    select.append('<option value="">No businesses found</option>');
                }

                // Restore old value if validation failed
                const oldBusinessId = '{{ old("business_id") }}';
                if (oldBusinessId && oldBusinessId !== '') {
                    select.val(oldBusinessId);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                $("#businessSelect").html('<option value="">Error loading businesses</option>');
            }
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
        const title = document.querySelector('input[name="title"]');
        const desc  = document.querySelector('textarea[name="description"]');
        const val   = document.querySelector('input[name="discount_value"]');
        const type  = document.querySelector('select[name="discount_type"]');
        const min   = document.querySelector('input[name="min_purchase"]');
        const sd    = document.querySelector('input[name="start_date"]');
        const ed    = document.querySelector('input[name="end_date"]');
        const code  = document.querySelector('input[name="promo_code"]');
        const status= document.querySelector('select[name="status"]');

        $(document).ready(function () {
        // Load businesses automatically on page load
        $.ajax({
            url: "{{ route('show-businesses-list') }}",
            type: "GET",
            success: function (res) {
                let select = $("#businessSelect");
                select.empty();
                select.append('<option value="">Select a business...</option>');

                if (res.success && res.businesses && res.businesses.length > 0) {
                    $.each(res.businesses, function (index, business) {
                        select.append(`<option value="${business.id}">${business.name}</option>`);
                    });
                } else {
                    select.append('<option value="">No businesses found</option>');
                }

                // Restore old value if validation failed
                const oldBusinessId = '{{ old("business_id") }}';
                if (oldBusinessId && oldBusinessId !== '') {
                    select.val(oldBusinessId);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                $("#businessSelect").html('<option value="">Error loading businesses</option>');
            }
        });
    });

    function updatePreview() {
        document.getElementById('pvTitle').textContent = title.value || 'Your deal title';
        document.getElementById('pvDesc').textContent  = desc.value || 'Short description of the deal will appear here.';

        const v = parseFloat(val.value || '0');
        const isPercent = type.value === 'percentage';
        const valueText = v > 0 ? (isPercent ? `${v}% OFF` : `₹${v.toFixed(2)} OFF`) : '0% OFF';
        document.getElementById('pvValue').textContent = valueText;

        document.getElementById('pvType').textContent  = isPercent ? 'Percentage discount' : 'Flat amount';

        const minEl = document.getElementById('pvMin');
        if (min.value && parseFloat(min.value) > 0) {
            minEl.textContent = `Min purchase ₹${parseFloat(min.value).toFixed(2)}`;
        } else {
            minEl.textContent = 'No minimum';
        }

        const dateTxt = (sd.value || 'Start date') + ' → ' + (ed.value || 'End date');
        document.getElementById('pvDates').textContent = dateTxt;

        const codeEl = document.getElementById('pvCode');
        codeEl.textContent = code.value ? `Code: ${code.value}` : 'No code';

        const badge = document.getElementById('pvStatusBadge');
        if (status.value === 'inactive') {
            badge.textContent = 'Inactive';
            badge.style.background = 'rgba(239,68,68,0.2)';
            badge.style.color = '#fecaca';
        } else {
            badge.textContent = 'Active';
            badge.style.background = 'rgba(34,197,94,0.15)';
            badge.style.color = '#bbf7d0';
        }
    }

    [title, desc, val, type, min, sd, ed, code, status].forEach(el => {
        if (el) el.addEventListener('input', updatePreview);
        if (el) el.addEventListener('change', updatePreview);
    });

    updatePreview();
});
</script> -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function () {
    // Load businesses
    $.ajax({
        url: "{{ route('show-businesses-list') }}",
        type: "GET",
        success: function (res) {
            
            let select = $("#businessSelect");
            select.empty();
            select.append('<option value="">Select a business...</option>');

            if (res.success && res.businesses && res.businesses.length > 0) {
                $.each(res.businesses, function (index, business) {
                    select.append(`<option value="${business.id}">${business.name}</option>`);
                });
            } else {
                select.append('<option value="">No businesses found</option>');
            }

            // Restore old value
            // const oldBusinessId = '{{ old("business_id") }}';
            const oldBusinessId = '{{ isset($deal) ? $deal->business_id : old("business_id") }}';
            if (oldBusinessId && oldBusinessId !== '') {
                select.val(oldBusinessId);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', xhr.responseText);
            $("#businessSelect").html('<option value="">Error loading businesses</option>');
        }
    });

    // ✅ Selected locations (Edit: from controller; Create: [])
// ✅ Get selected locations from controller (Edit mode) or old() validation
const selectedLocationIds = @json(
    old('location_ids', isset($selectedLocationIds) ? $selectedLocationIds : [])
);

console.log('✅ Selected Location IDs:', selectedLocationIds);

function renderLocations(locations) {
    const container = $('#locationsContainer');

    if (!locations || locations.length === 0) {
        container.html('<div class="helper">No locations found for this business.</div>');
        return;
    }

    let html = '';
    locations.forEach(loc => {
        // ✅ Check if location is in selectedLocationIds array
        const isChecked = selectedLocationIds.includes(loc.id);
        
        html += `
            <div class="form-check mb-2">
                <input class="form-check-input" 
                       type="checkbox"
                       name="location_ids[]"
                       id="loc_${loc.id}"
                       value="${loc.id}"
                       ${isChecked ? 'checked' : ''}>
                <label class="form-check-label" for="loc_${loc.id}" style="color:#e5e7eb;">
                    ${loc.branch_name}
                </label>
            </div>
        `;
    });

    container.html(html);
    console.log('✅ Locations rendered with pre-checked boxes');
}

function loadLocationsForBusiness(businessId) {
    const container = $('#locationsContainer');

    if (!businessId) {
        container.html('<div class="helper">Select a business to load locations.</div>');
        return;
    }

    container.html('<div class="helper">Loading locations...</div>');

    $.ajax({
        url: "/deals/locations-list",
        type: "GET",
        data: { business_id: businessId },
        dataType: "json",
        success: function (res) {
            console.log('✅ Locations fetched from AJAX:', res.locations);
            if (res.locations) {
                renderLocations(res.locations);
            } else {
                container.html('<div class="helper text-warning">No locations found.</div>');
            }
        },
        error: function (xhr) {
            container.html('<div class="helper text-danger">Error loading locations.</div>');
            console.error('❌ Error:', xhr.responseText);
        }
    });
}

// ✅ On business dropdown change, reload locations
$('#businessSelect').on('change', function () {
    console.log('📍 Business changed to:', $(this).val());
    loadLocationsForBusiness($(this).val());
});

// ✅ CRITICAL: On page load, automatically show locations for edit
$(document).ready(function() {
    console.log('🚀 Page loaded, checking for business...');
    
    const businessId = $('#businessSelect').val();
    console.log('📍 Business ID found:', businessId);
    
    if (businessId) {
        console.log('✅ Loading locations automatically...');
        loadLocationsForBusiness(businessId);
    } else {
        console.log('⚠️  No business selected on page load');
    }
});




    // Live preview function
    function updatePreview() {
        $('#pvTitle').text($('input[name="title"]').val() || 'Your deal title');
        $('#pvDesc').text($('textarea[name="description"]').val() || 'Short description...');

        const val = parseFloat($('input[name="discount_value"]').val() || '0');
        const type = $('select[name="discount_type"]').val();
        const isPercent = type === 'percentage';
        const valueText = val > 0 ? (isPercent ? `${val}% OFF` : `₹${val.toFixed(2)} OFF`) : '0% OFF';
        $('#pvValue').text(valueText);

        $('#pvType').text(isPercent ? 'Percentage discount' : 'Flat amount');

        const minVal = $('input[name="min_purchase"]').val();
        $('#pvMin').text(minVal && parseFloat(minVal) > 0 ? `Min purchase ₹${parseFloat(minVal).toFixed(2)}` : 'No minimum');

        $('#pvDates').text(($('input[name="start_date"]').val() || 'Start') + ' → ' + ($('input[name="end_date"]').val() || 'End'));

        $('#pvCode').text($('input[name="promo_code"]').val() ? `Code: ${$('input[name="promo_code"]').val()}` : 'No code');

        const status = $('select[name="status"]').val();
        const badge = $('#pvStatusBadge');
        if (status === 'inactive') {
            badge.text('Inactive').css({'background': 'rgba(239,68,68,0.2)', 'color': '#fecaca'});
        } else {
            badge.text('Active').css({'background': 'rgba(34,197,94,0.15)', 'color': '#bbf7d0'});
        }
    }

    // Event listeners - FIXED STRING CONCATENATION
    $('input[name="title"], textarea[name="description"], input[name="discount_value"], select[name="discount_type"], input[name="min_purchase"], input[name="start_date"], input[name="end_date"], input[name="promo_code"], select[name="status"], #businessSelect')
        .on('input change', updatePreview);

    updatePreview(); // Initial call
});
</script>


@endsection
