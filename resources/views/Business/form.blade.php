@extends('layouts.app')

@section('content')

<style>
    /* --- Styles (Unchanged as requested) --- */
    :root {
        --primary: #4f46e5;
        --secondary: #06b6d4;
        --dark: #0f172a;
        --light: #f8fafc;
        --glass-bg: rgba(255, 255, 255, 0.95);
        --glass-border: rgba(255, 255, 255, 0.5);
    }

    body {
        background-color: #f1f5f9;
        background-image: radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.05) 0px, transparent 50%),
                          radial-gradient(at 100% 100%, rgba(6, 182, 212, 0.05) 0px, transparent 50%);
    }

    .page-header { margin-bottom: 2rem; }

    .form-card {
        background: var(--glass-bg);
        border: 1px solid white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .card-header-custom {
        background: linear-gradient(to right, rgba(255,255,255,0.8), rgba(255,255,255,0.4));
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 1.5rem 2rem;
    }

    .section-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        margin-right: 1rem;
        font-size: 1.2rem;
        color: white;
    }
    .icon-brand { background: linear-gradient(135deg, #4f46e5, #818cf8); }
    .icon-loc { background: linear-gradient(135deg, #059669, #34d399); }

    .form-label {
        font-weight: 600; font-size: 0.85rem; text-transform: uppercase;
        letter-spacing: 0.5px; color: #64748b; margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border: 2px solid #e2e8f0; border-radius: 10px; padding: 0.75rem 1rem; transition: all 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--primary); box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }

    .upload-zone {
        border: 2px dashed #cbd5e1; border-radius: 12px; background: #f8fafc;
        padding: 2rem; text-align: center; cursor: pointer; transition: 0.2s; position: relative;
    }
    .upload-zone:hover { border-color: var(--primary); background: #eef2ff; }
    .upload-zone input[type="file"] {
        position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer;
    }

    .location-card {
        background: white; border: 1px solid #e2e8f0; border-radius: 12px;
        padding: 1.5rem; position: relative; transition: 0.2s; margin-bottom: 1rem;
    }
    .location-card:hover { border-color: var(--secondary); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    .remove-btn {
        position: absolute; top: 1rem; right: 1rem; color: #ef4444; opacity: 0.6;
        transition:0.2s; background: none; border: none;
    }
    .remove-btn:hover { opacity: 1; transform: scale(1.1); }

    .sticky-sidebar { position: -webkit-sticky; position: sticky; top: 100px; }

    .preview-card {
        background: white; border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        padding: 2rem; text-align: center;
    }

    .preview-logo {
        width: 100px; height: 100px; object-fit: cover; border-radius: 20px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 1rem;
        background-color: #f1f5f9; display: inline-block;
    }

    @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-in { animation: slideUp 0.6s ease-out forwards; }
    #addLocationBtn { transition: transform .15s ease; }
    #addLocationBtn:hover { transform: translateY(-2px); }
    #addLocationBtn:active { transform: scale(.95); }
</style>

<div class="container py-5">
    
    <div class="page-header d-flex justify-content-between align-items-center animate-in">
        <div>
            <h2 class="fw-bold text-dark mb-1">{{ isset($business) ? 'Edit Business' : 'Add New Business' }}</h2>
            <p class="text-muted mb-0">
                {{ isset($business) ? 'Update your business details and locations below.' : 'Fill in the details to list your business and branches.' }}
            </p>
        </div>
        <a href="{{ route('business.showAll') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Cancel
        </a>
    </div>

    <form action="{{ isset($business) ? route('business.update', $business->id) : route('business.store') }}" 
          method="POST" 
          enctype="multipart/form-data"
          id="businessForm">
    
        @csrf
        @if(isset($business))
            @method('PUT')
        @endif

        <div class="row g-4">
            
            <div class="col-lg-8 animate-in" style="animation-delay: 0.1s;">
                
                <div class="form-card">
                    <div class="card-header-custom d-flex align-items-center">
                        <div class="section-icon icon-brand"><i class="bi bi-shop"></i></div>
                        <div>
                            <h5 class="fw-bold mb-0">Brand Information</h5>
                            <small class="text-muted">General details about your company.</small>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="row g-3">
                            <input type="hidden" name="owner_id" value="{{ session('owner_id') ?? ($owner->id ?? '') }}">

                            <div class="col-md-6">
                                <label class="form-label">Business Name</label>
                                <input type="text" name="business_name" class="form-control" 
                                       placeholder="e.g. Your Business" 
                                       value="{{ old('business_name', $business->business_name ?? '') }}" 
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select name="category_id" id="categorySelect" class="form-select" required>
                                    <option value="">Loading categories...</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Business Logo</label>
                                <div class="upload-zone">
                                    <input type="file" name="logo_file" id="logoFile" accept="image/*" {{ isset($business) ? '' : 'required' }}>
                                    <div class="text-muted">
                                        <i class="bi bi-cloud-arrow-up fs-2 text-primary"></i>
                                        <p class="mb-0 fw-semibold">Click or Drag new logo here</p>
                                        <small>{{ isset($business) ? 'Leave empty to keep current logo' : 'JPG, PNG up to 4MB' }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" 
                                          placeholder="Tell customers what you do...">{{ old('description', $business->description ?? '') }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="active" {{ old('status', $business->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $business->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Main Email</label>
                                <input type="email" name="email" id="businessEmail" class="form-control" 
                                       placeholder="contact@business.com" 
                                       value="{{ old('email', $business->email ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Main Phone</label>
                                <input type="text" name="phone" id="businessPhone" class="form-control" 
                                       placeholder="+1 234 567 890" 
                                       value="{{ old('phone', $business->phone ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-card">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="section-icon icon-loc"><i class="bi bi-geo-alt"></i></div>
                            <div>
                                <h5 class="fw-bold mb-0">Locations</h5>
                                <small class="text-muted">Where can customers find you?</small>
                            </div>
                        </div>
                        <button type="button" id="addLocationBtn" 
                            class="btn btn-dark btn-sm rounded-pill px-3 shadow-sm d-flex align-items-center gap-1">
                            <i class="bi bi-plus-lg"></i> Add Branch
                        </button>
                    </div>
                    
                    <div class="p-4 bg-light">
                        <div id="locationsWrapper">
                            </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 shadow-sm">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-sm" 
                        style="background: linear-gradient(135deg, #4f46e5, #4338ca); border:none;">
                    {{ isset($business) ? 'Update Business' : 'Save & Publish Business' }}
                </button>

            </div>

            <div class="col-lg-4 animate-in" style="animation-delay: 0.2s;">
                <div class="sticky-sidebar">
                    <h6 class="text-uppercase fw-bold text-muted mb-3 small ms-1">Live Preview</h6>
                    
                    <div class="preview-card">
                        <img id="logoPreview" 
                             src="{{ isset($business) && $business->logo_url ? Storage::url($business->logo_url) : 'https://via.placeholder.com/150?text=Logo' }}" 
                             class="preview-logo" 
                             alt="Logo Preview">
                        
                        <h4 class="fw-bold mb-1" id="liveName">{{ $business->business_name ?? 'Your Business Name' }}</h4>
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-3" id="liveCat">Category</span>
                        
                        <hr class="opacity-10 my-3">
                        
                        <div class="text-start">
                            <div class="d-flex align-items-center mb-2 text-muted">
                                <i class="bi bi-envelope me-2"></i> 
                                <span id="liveEmail" class="small">{{ $business->email ?? 'email@example.com' }}</span>
                            </div>
                            <div class="d-flex align-items-center text-muted">
                                <i class="bi bi-telephone me-2"></i> 
                                <span id="livePhone" class="small">{{ $business->phone ?? '+1 234 ...' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 shadow-sm mt-4 rounded-3">
                        <div class="d-flex">
                            <i class="bi bi-info-circle-fill fs-5 me-2"></i>
                            <small>Make sure to add at least one location. The first location added will be set as primary by default if not specified.</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<template id="locationTemplate">
    <div class="location-card animate-in">
        <div class="d-flex justify-content-between mb-3">
            <span class="badge bg-secondary">Branch #<span class="loc-index"></span></span>
            <input type="hidden" name="locations[__IDX__][id]" class="loc-id-input">
            <button type="button" class="remove-btn remove-location"><i class="bi bi-trash-fill fs-5"></i></button>
        </div>

        <div class="row g-2">
            <div class="col-md-12 mb-2">
                <input type="text" name="locations[__IDX__][branch_name]" class="form-control loc-name" placeholder="Branch Name (e.g. Downtown)" required>
            </div>
            
            <div class="col-12 mb-2">
                <input type="text" name="locations[__IDX__][address]" class="form-control loc-address" placeholder="Street Address" required>
            </div>

            <div class="col-md-4">
                <input type="text" name="locations[__IDX__][city]" class="form-control loc-city" placeholder="City" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="locations[__IDX__][state]" class="form-control loc-state" placeholder="State" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="locations[__IDX__][postal_code]" class="form-control loc-zip" placeholder="Zip" required>
            </div>
            
            <div class="col-md-6 mt-2">
                <input type="text" name="locations[__IDX__][country]" class="form-control loc-country" placeholder="Country" required>
            </div>
            <div class="col-md-6 mt-2">
                 <input type="text" name="locations[__IDX__][phone]" class="form-control loc-phone" placeholder="Branch Phone (Optional)">
            </div>
            <div class="col-md-6 mt-2">
                 <input type="text" name="locations[__IDX__][email]" class="form-control loc-email" placeholder="Branch email (Optional)">
            </div>

            <div class="col-12 mt-3">
                <div class="form-check form-switch">
                    <input class="form-check-input is-primary-input" type="checkbox" name="locations[__IDX__][is_primary]" value="1">
                    <label class="form-check-label small fw-bold text-dark">Set as Primary Head Office</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function () {
    let idx = 0;
    
    // Store existing category ID for pre-selection
    const editingCategoryId = "{{ $business->category_id ?? '' }}";

    // 1. Fetch Categories and Pre-select if editing
    $.ajax({
        url: "{{ route('show-category') }}",
        type: "GET",
        success: function (res) {
            let select = $("#categorySelect");
            select.empty(); 
            select.append('<option value="">Select Category...</option>');

            $.each(res.categories, function (index, cat) {
                let isSelected = (String(cat.id) === String(editingCategoryId)) ? 'selected' : '';
                select.append(`<option value="${cat.id}" ${isSelected}>${cat.name}</option>`);
            });
            
            // Trigger change to update preview text
            if(editingCategoryId) select.trigger('change');
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert("Error loading categories");
        }
    });

    // 2. Initialize Locations
    // If editing, loop through existing locations using Blade data
    @if(isset($business) && $business->locations->count() > 0)
        const existingLocations = @json($business->locations);
        existingLocations.forEach(loc => {
            addLocation(loc);
        });
    @else
        // If creating new, add one empty block
        addLocation(); 
    @endif

    // 3. Add Location Logic
    $('#addLocationBtn').on('click', function () {
        addLocation();
    });

    // 4. Remove Location Logic
    $('#locationsWrapper').on('click', '.remove-location', function () {
        if($('#locationsWrapper .location-card').length > 1) {
            $(this).closest('.location-card').remove();
            updateLocationIndexes();
        } else {
            alert("You need at least one location.");
        }
    });

    // 5. Live Preview Logic
    $('input[name="business_name"]').on('input', function() {
        $('#liveName').text($(this).val() || 'Your Business Name');
    });

    $('#categorySelect').on('change', function() {
        $('#liveCat').text($(this).find('option:selected').text());
    });
    
    $('#businessEmail').on('input', function() {
        $('#liveEmail').text($(this).val() || 'email@example.com');
    });
    
    $('#businessPhone').on('input', function() {
        $('#livePhone').text($(this).val() || '+1 234 ...');
    });

    // 6. Logo Preview Logic
    $('#logoFile').on('change', function(e){
        const file = e.target.files[0];
        if (file) {
            const url = URL.createObjectURL(file);
            $('#logoPreview').attr('src', url);
        }
    });

    // 7. Form Submission Logic
    $('#businessForm').on('submit', function(e) {
        const $primaries = $('.is-primary-input:checked');
        if ($primaries.length === 0) {
            // Default first to primary if none selected
            $('.is-primary-input').first().prop('checked', true);
        } else if ($primaries.length > 1) {
            // Ensure only one is primary
            $primaries.not(':first').prop('checked', false);
        }
    });

    // --- Helper Functions ---
    function addLocation(data = null) {
        const template = $('#locationTemplate').html();
        const html = template.replace(/__IDX__/g, idx);
        const $el = $(html);

        // Pre-fill data if provided (Edit Mode)
        if (data) {
            $el.find('.loc-id-input').val(data.id);
            $el.find('.loc-name').val(data.branch_name);
            $el.find('.loc-address').val(data.address);
            $el.find('.loc-city').val(data.city);
            $el.find('.loc-state').val(data.state);
            $el.find('.loc-zip').val(data.postal_code);
            $el.find('.loc-country').val(data.country);
            $el.find('.loc-phone').val(data.phone);
            $el.find('.loc-email').val(data.email);
            if(data.is_primary == 1) {
                $el.find('.is-primary-input').prop('checked', true);
            }
        }

        $('#locationsWrapper').append($el);
        updateLocationIndexes();
        idx++;
    }

    function updateLocationIndexes() {
        $('#locationsWrapper .location-card').each(function(i){
            $(this).find('.loc-index').text(i+1);
        });
    }
});
</script>

@endsection