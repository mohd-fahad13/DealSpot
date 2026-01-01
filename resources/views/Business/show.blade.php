@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* --- THEME ENGINE --- */
:root {
    --bg-body: #020617;
    --bg-surface: #0f172a;
    --glass-bg: rgba(30, 41, 59, 0.6);
    --glass-border: rgba(255, 255, 255, 0.08);
    --text-main: #f8fafc;
    --text-muted: #94a3b8;
    --primary: #6366f1;
    --secondary: #06b6d4;
    --success: #10b981;
    --warning: #f59e0b;
}

[data-theme="light"] {
    --bg-body: #f1f5f9;
    --bg-surface: #ffffff;
    --glass-bg: rgba(255, 255, 255, 0.8);
    --glass-border: rgba(0, 0, 0, 0.08);
    --text-main: #0f172a;
    --text-muted: #64748b;
}

/* --- BASE --- */
body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background-color: var(--bg-body);
    color: var(--text-main);
    background-image: 
        radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
        radial-gradient(at 100% 100%, rgba(6, 182, 212, 0.15) 0px, transparent 50%);
    min-height: 100vh;
    overflow-x: hidden;
}

.details-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1.5rem;
}

/* --- ANIMATIONS --- */
@keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
@keyframes pulseGlow { 0% { box-shadow: 0 0 0 0 rgba(99,102,241,0.4); } 70% { box-shadow: 0 0 0 15px rgba(0,0,0,0); } 100% { box-shadow: 0 0 0 0 rgba(0,0,0,0); } }

/* The Infinity Animation (Slow rotation for background elements) */
@keyframes infinitySpin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* --- COMPONENTS --- */
.glass-card {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    backdrop-filter: blur(16px);
    border-radius: 24px;
    padding: 2rem;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    animation: slideUp 0.6s ease-out;
    position: relative;
    overflow: hidden;
}

/* --- HERO SECTION --- */
.hero-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
    margin-bottom: 2.5rem;
    padding: 2.5rem;
    background: linear-gradient(135deg, rgba(15,23,42,0.9), rgba(15,23,42,0.7));
    border: 1px solid var(--glass-border);
    border-radius: 24px;
    position: relative;
}

/* Infinity Decor in Hero */
.hero-infinity {
    position: absolute;
    right: -50px; top: -50px;
    width: 200px; height: 200px;
    border: 2px dashed var(--primary);
    border-radius: 50%;
    opacity: 0.1;
    animation: infinitySpin 20s linear infinite;
    pointer-events: none;
}

.business-profile {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    z-index: 2;
}

.profile-img-box {
    width: 100px; height: 100px;
    border-radius: 20px;
    overflow: hidden;
    border: 2px solid var(--glass-border);
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    position: relative;
}
.profile-img-box img { width: 100%; height: 100%; object-fit: cover; }
.profile-placeholder {
    width: 100%; height: 100%;
    background: linear-gradient(135deg, var(--bg-surface), var(--bg-body));
    display: flex; align-items: center; justify-content: center;
    font-size: 2.5rem; color: var(--text-muted);
}

.profile-info h1 {
    font-size: 2.5rem; font-weight: 800;
    margin-bottom: 0.5rem;
    background: linear-gradient(to right, #fff, #cbd5e1);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
}

.badge-group { display: flex; gap: 0.8rem; align-items: center; }
.custom-badge {
    padding: 0.4rem 1rem; border-radius: 50px;
    font-size: 0.8rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.5px;
    display: flex; align-items: center; gap: 6px;
    backdrop-filter: blur(4px);
}
.badge-category { background: rgba(99,102,241,0.15); color: var(--primary); border: 1px solid rgba(99,102,241,0.3); }
.badge-status { background: rgba(16,185,129,0.15); color: var(--success); border: 1px solid rgba(16,185,129,0.3); }
.badge-status.inactive { background: rgba(245,158,11,0.15); color: var(--warning); border: 1px solid rgba(245,158,11,0.3); }

/* Buttons */
.action-btn {
    padding: 0.8rem 1.5rem; border-radius: 12px;
    font-weight: 600; text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex; align-items: center; gap: 0.5rem;
}
.btn-edit {
    background: linear-gradient(135deg, var(--primary), #818cf8);
    color: white; border: none;
    box-shadow: 0 4px 15px rgba(99,102,241,0.4);
}
.btn-edit:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(99,102,241,0.6); color: white; }
.btn-back {
    background: transparent; border: 1px solid var(--glass-border); color: var(--text-muted);
}
.btn-back:hover { background: var(--glass-border); color: var(--text-main); }

/* --- GRID LAYOUT --- */
.content-grid {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 2rem;
}

/* Info Cards */
.info-section-title {
    font-size: 1.1rem; font-weight: 700; color: var(--text-main);
    margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.8rem;
}
.info-row {
    display: flex; flex-direction: column; gap: 0.4rem;
    margin-bottom: 1.5rem; padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--glass-border);
}
.info-row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.info-label { font-size: 0.8rem; text-transform: uppercase; color: var(--text-muted); font-weight: 600; letter-spacing: 0.5px; }
.info-value { font-size: 1rem; color: var(--text-main); font-weight: 500; }

/* Location Cards */
.location-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;
}
.location-card {
    background: var(--bg-surface);
    border: 1px solid var(--glass-border);
    border-radius: 20px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}
.location-card:hover {
    transform: translateY(-5px);
    border-color: var(--primary);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}
.loc-header {
    display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;
}
.loc-title { font-size: 1.1rem; font-weight: 700; color: var(--text-main); }
.primary-tag {
    font-size: 0.7rem; background: var(--primary); color: white;
    padding: 3px 8px; border-radius: 6px; font-weight: 700; text-transform: uppercase;
}
.loc-detail {
    display: flex; align-items: center; gap: 0.8rem;
    color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.6rem;
}
.loc-detail i { color: var(--primary); }

/* Empty State */
.empty-locations {
    text-align: center; padding: 4rem;
    border: 2px dashed var(--glass-border); border-radius: 24px;
    color: var(--text-muted);
}

@media (max-width: 992px) {
    .content-grid { grid-template-columns: 1fr; }
    .hero-section { flex-direction: column; text-align: center; padding: 2rem; }
    .business-profile { flex-direction: column; }
    .profile-info h1 { font-size: 2rem; }
    .badge-group { justify-content: center; }
}
</style>

<div class="details-container">

    <div class="hero-section">
        <div class="hero-infinity"></div> <div class="business-profile">
            <div class="profile-img-box">
                @if($business->logo_url)
                    <img src="{{ Storage::url($business->logo_url) }}" alt="Logo">
                @else
                    <div class="profile-placeholder">
                        <i class="bi bi-buildings"></i>
                    </div>
                @endif
            </div>

            <div class="profile-info">
                <h1>{{ $business->business_name }}</h1>
                <div class="badge-group">
                    @if($business->category)
                        <div class="custom-badge badge-category">
                            <i class="bi bi-tag-fill"></i> {{ $business->category->name }}
                        </div>
                    @endif
                    <div class="custom-badge badge-status {{ $business->status !== 'active' ? 'inactive' : '' }}">
                        <div style="width:8px;height:8px;border-radius:50%;background:currentColor;box-shadow:0 0 8px currentColor;"></div>
                        {{ ucfirst($business->status) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-3">
            <a href="{{ route('business.showAll') }}" class="action-btn btn-back">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <a href="{{ route('business.edit', $business->id) }}" class="action-btn btn-edit">
                <i class="bi bi-pencil-square"></i> Edit Details
            </a>
        </div>
    </div>

    <div class="content-grid">
        
        <div class="glass-card h-100">
            <div class="info-section-title">
                <div style="padding:8px;background:rgba(255,255,255,0.05);border-radius:8px;"><i class="bi bi-info-circle text-primary"></i></div>
                About Business
            </div>

            <div class="info-row">
                <span class="info-label">Description</span>
                <span class="info-value" style="line-height:1.6;">
                    {{ $business->description ?: 'No description provided.' }}
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Primary Email</span>
                <span class="info-value">
                    @if($business->email)
                        <a href="mailto:{{ $business->email }}" class="text-decoration-none text-white hover-underline">
                            {{ $business->email }}
                        </a>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Phone Number</span>
                <span class="info-value">{{ $business->phone ?: '—' }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Registered On</span>
                <span class="info-value">{{ $business->created_at->format('M d, Y') }}</span>
            </div>
        </div>

        <div>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3 class="fw-bold m-0" style="font-size:1.5rem;">
                    <i class="bi bi-geo-alt-fill text-secondary me-2"></i> Locations 
                    <span class="text-muted fs-6 ms-2">({{ $business->locations->count() }})</span>
                </h3>
            </div>

            @if($business->locations->count() > 0)
                <div class="location-grid">
                    @foreach($business->locations as $location)
                        <div class="location-card" style="animation-delay: {{ $loop->index * 0.1 }}s; animation-name: slideUp; animation-duration: 0.5s; animation-fill-mode: backwards;">
                            <div class="loc-header">
                                <div class="loc-title">{{ $location->branch_name }}</div>
                                @if($location->is_primary)
                                    <div class="primary-tag">Head Office</div>
                                @endif
                            </div>

                            <div class="loc-detail">
                                <i class="bi bi-geo-alt"></i>
                                <span>{{ $location->address }}, {{ $location->city }}</span>
                            </div>
                            <div class="loc-detail">
                                <i class="bi bi-map"></i>
                                <span>{{ $location->state }}, {{ $location->country }}</span>
                            </div>

                            @if($location->phone || $location->email)
                                <div style="margin: 1rem 0; height: 1px; background: var(--glass-border);"></div>
                                @if($location->phone)
                                    <div class="loc-detail">
                                        <i class="bi bi-telephone-fill" style="font-size:0.8rem;"></i> {{ $location->phone }}
                                    </div>
                                @endif
                                @if($location->email)
                                    <div class="loc-detail">
                                        <i class="bi bi-envelope-fill" style="font-size:0.8rem;"></i> {{ $location->email }}
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-locations">
                    <div style="animation: float 3s ease-in-out infinite;">
                        <i class="bi bi-shop-window" style="font-size: 4rem; opacity: 0.3;"></i>
                    </div>
                    <h4 class="mt-3 fw-bold">No Locations Found</h4>
                    <p>This business has not added any branch locations yet.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection