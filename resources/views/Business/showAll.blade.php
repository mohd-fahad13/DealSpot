@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root {
    --bg-deep: #020617;
    --bg-surface: #0f172a;
    --primary-glow: #38bdf8;
    --secondary-glow: #818cf8;
    --accent-glow: #c084fc;
    --text-main: #f8fafc;
    --text-muted: #94a3b8;
    --card-glass: rgba(30, 41, 59, 0.7);
    --border-glass: rgba(255, 255, 255, 0.08);
}

/* Light mode overrides */
[data-theme="light"] {
    --bg-deep: #f3f4f6;
    --bg-surface: #ffffff;
    --card-glass: rgba(255,255,255,0.95);
    --border-glass: rgba(15,23,42,0.08);
    --text-main: #0f172a;
    --text-muted: #6b7280;
}

/* Base */
body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background-color: var(--bg-deep);
    background-image:
        radial-gradient(at 0% 0%, rgba(56, 189, 248, 0.15) 0px, transparent 50%),
        radial-gradient(at 100% 0%, rgba(192, 132, 252, 0.15) 0px, transparent 50%);
    min-height: 100vh;
    color: var(--text-main);
    overflow-x: hidden;
}

/* Animations */
@keyframes fadeSlideUp { from {opacity:0; transform:translateY(30px);} to {opacity:1; transform:translateY(0);} }
@keyframes pulseSoft {0%{box-shadow:0 0 0 0 rgba(56,189,248,0.4);}70%{box-shadow:0 0 0 12px rgba(56,189,248,0);}100%{box-shadow:0 0 0 0 rgba(56,189,248,0);}}
@keyframes float {0%{transform:translateY(0);}50%{transform:translateY(-6px);}100%{transform:translateY(0);}}

/* Layout Container */
.dashboard-root {
    max-width: 1440px;
    margin: 0 auto;
    padding: 2rem 1.5rem 4rem; /* Added bottom padding to breathe before footer */
}

/* Hero */
.hero-header {
    position: relative;
    margin-bottom: 2.5rem;
    padding: 2.4rem 2.2rem;
    border-radius: 24px;
    background: linear-gradient(135deg, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.6));
    border: 1px solid var(--border-glass);
    backdrop-filter: blur(20px);
    overflow: hidden;
    animation: fadeSlideUp 0.8s ease-out;
}
.hero-header::before {
    content:'';
    position:absolute;
    top:0;left:0;right:0;height:1px;
    background:linear-gradient(90deg,transparent,var(--primary-glow),transparent);
    opacity:.5;
}
.hero-inner {
    position:relative;
    z-index:1;
    display:flex;
    flex-wrap:wrap;
    gap:1.5rem;
    justify-content:space-between;
    align-items:flex-start;
}
.hero-title {
    font-size:2.6rem;
    font-weight:800;
    background:linear-gradient(to right,#fff,#94a3b8);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    letter-spacing:-1px;
    margin-bottom:.6rem;
}
.hero-sub {
    color:var(--text-muted);
    max-width:600px;
}

/* Stats chips */
.stats-row {
    display:flex;
    gap:1rem;
    margin-top:1.2rem;
    flex-wrap:wrap;
}
.stat-badge {
    display:flex;
    align-items:center;
    gap:.6rem;
    padding:.55rem 1.1rem;
    background:rgba(255,255,255,0.03);
    border:1px solid var(--border-glass);
    border-radius:100px;
    font-size:.85rem;
    color:var(--text-muted);
}
.stat-badge strong {color:#fff;font-weight:700;}
.stat-badge i {color:var(--primary-glow);}

/* Theme toggle */
.theme-toggle {
    display:inline-flex;
    align-items:center;
    gap:.5rem;
    padding:.4rem .8rem;
    border-radius:999px;
    border:1px solid var(--border-glass);
    background:rgba(15,23,42,0.7);
    color:var(--text-muted);
    font-size:.8rem;
    cursor:pointer;
}
.theme-switch {
    width:40px;height:20px;
    border-radius:999px;
    border:1px solid var(--border-glass);
    background:rgba(15,23,42,0.95);
    position:relative;
}
.theme-knob {
    position:absolute;
    top:1px;left:1px;
    width:16px;height:16px;
    border-radius:999px;
    background:linear-gradient(135deg,var(--primary-glow),var(--secondary-glow));
    transition:transform .2s ease;
}
[data-theme="light"] .theme-knob {transform:translateX(18px);}

/* CTA */
.btn-premium {
    position:relative;
    padding:.85rem 1.7rem;
    background:linear-gradient(135deg,var(--primary-glow),var(--secondary-glow));
    color:#fff;
    border:none;
    border-radius:12px;
    font-weight:700;
    font-size:.95rem;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:.6rem;
    box-shadow:0 10px 30px -10px rgba(56,189,248,0.5);
    transition:all .3s;
}
.btn-premium:hover {
    transform:translateY(-3px);
    box-shadow:0 18px 40px -10px rgba(56,189,248,0.7);
    color:#fff;
}

/* =========================================
   MAIN LAYOUT & FOCUS MODE
   ========================================= */

.main-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    align-items: start; /* Prevents stretching to full height */
    min-height: 50vh; /* Minimum height but not forced to screen bottom */
    position: relative;
    transition: grid-template-columns 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

/* Grid of cards - Default */
.grid-businesses {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.6rem;
    width: 100%;
    transition: all 0.5s ease;
}

/* --- FOCUS MODE ACTIVE --- */

/* 1. Split Layout: Fixed List Width | Flexible Panel Width */
#bizRoot.focus-mode .main-layout {
    grid-template-columns: 380px 1fr !important;
    gap: 1.5rem !important;
}

/* 2. Force single column for the list */
#bizRoot.focus-mode .grid-businesses {
    grid-template-columns: 1fr !important;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* 3. Panel Visibility */
#bizRoot.focus-mode .side-panel {
    opacity: 1;
    pointer-events: auto;
    transform: translateX(0);
}

/* 4. Active Card Styling */
#bizRoot.focus-mode .biz-card.is-focused {
    transform: scale(1.02);
    border-color: var(--primary-glow);
    box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.3), 0 20px 40px rgba(0,0,0,0.4);
}

/* 5. Inactive Cards Fade */
#bizRoot.focus-mode .biz-card:not(.is-focused) {
    opacity: 0.6;
    transform: scale(0.98);
}
#bizRoot.focus-mode .biz-card:not(.is-focused):hover {
    opacity: 1;
    transform: scale(1);
}

/* =========================================
   COMPONENTS
   ========================================= */

/* Business Card */
.biz-card {
    background: var(--card-glass);
    border: 1px solid var(--border-glass);
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    backdrop-filter: blur(12px);
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    animation: fadeSlideUp 0.6s ease-out backwards;
    display: flex;
    flex-direction: column;
}

.biz-card:hover:not(.is-focused) {
    transform: translateY(-8px);
    border-color: rgba(56,189,248,0.35);
    box-shadow: 0 20px 40px rgba(15,23,42,0.7);
}

/* Card image */
.card-img-wrapper {
    height: 200px;
    position: relative;
    overflow: hidden;
    transition: height 0.4s ease;
}

/* Shrink image in focus mode to save space */
#bizRoot.focus-mode .card-img-wrapper {
    height: 140px;
}

.card-img-wrapper img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.8s ease;
}
.biz-card:hover .card-img-wrapper img {
    transform: scale(1.06);
}
.card-gradient-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, var(--bg-surface), transparent);
    z-index: 1;
}

/* Status pill */
.card-status {
    position: absolute;
    top: 1rem; right: 1rem;
    z-index: 2;
    padding: 0.35rem 0.85rem;
    background: rgba(15, 23, 42, 0.7);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(74,222,128,0.25);
    border-radius: 100px;
    color: #4ade80;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.status-dot {
    width: 8px; height: 8px;
    background: #4ade80;
    border-radius: 50%;
    animation: pulseSoft 2s infinite;
}

/* Card content */
.card-content {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    position: relative;
    z-index: 2;
}
.biz-category {
    color: var(--primary-glow);
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
}
.biz-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: 0.6rem;
}
.biz-desc {
    color: var(--text-muted);
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1.2rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Location strip */
.location-strip {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border-glass);
    color: #cbd5e1;
    font-size: 0.9rem;
    margin-bottom: 1.2rem;
}

/* Card actions */
.card-actions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr auto;
    gap: 0.5rem;
    margin-top: auto;
}
.action-link {
    padding: 0.7rem;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    transition: 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
}
.btn-manage {
    background: rgba(255,255,255,0.05);
    color: #fff;
    border: 1px solid var(--border-glass);
}
.btn-manage:hover {
    background: rgba(255,255,255,0.12);
    border-color: rgba(56,189,248,0.5);
}
.btn-deals {
    background: rgba(56,189,248,0.12);
    color: var(--primary-glow);
    border: 1px solid rgba(56,189,248,0.25);
}
.btn-menu {
    width: 42px;
    background: transparent;
    border: 1px solid var(--border-glass);
    color: var(--text-muted);
    display: flex; align-items: center; justify-content: center;
    border-radius: 10px;
}

/* SIDE PANEL */
.side-panel {
    background: var(--card-glass);
    border-radius: 24px;
    border: 1px solid var(--border-glass);
    backdrop-filter: blur(18px);
    padding: 1.5rem;
    
    /* Fixed Positioning Logic */
    position: sticky;
    top: 2rem;
    height: calc(100vh - 4rem); 
    overflow: hidden;
    
    display: flex;
    flex-direction: column;
    
    /* Animation Defaults */
    opacity: 0;
    pointer-events: none;
    transform: translateX(20px);
    transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    
    /* If screen is tall, this prevents it from being too tall */
    max-height: 800px;
}

/* Panel header */
.side-header {
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:.8rem;
    padding-bottom: .8rem;
    border-bottom: 1px solid var(--border-glass);
}
.side-title { font-size:.95rem; font-weight:700; }
.btn-close-panel {
    border:none; background:transparent; color:var(--text-muted);
    cursor:pointer; padding:.3rem; border-radius:6px; transition:.2s;
}
.btn-close-panel:hover { background:rgba(255,255,255,0.1); color:var(--text-main); }

/* Panel preview */
.side-preview {
    display:flex; gap:.75rem; border-radius:14px;
    border:1px solid var(--border-glass); padding:.8rem; margin-bottom:1rem;
    background: rgba(2, 6, 23, 0.3);
}
.side-logo {
    width:56px; height:56px; border-radius:12px; overflow:hidden;
    background:#020617; display:flex; align-items:center; justify-content:center;
}
.side-logo img { width:100%; height:100%; object-fit:cover; }
.side-preview-text h4 { font-size:.95rem; margin-bottom:.2rem; color: #fff; }
.side-preview-text p { font-size:.8rem; margin-bottom:.1rem; color:var(--text-muted); }

/* Panel scroll content */
.side-scroll {
    overflow-y: auto;
    padding-right: .5rem;
    flex: 1;
}
/* Scrollbar styling */
.side-scroll::-webkit-scrollbar { width: 4px; }
.side-scroll::-webkit-scrollbar-track { background: transparent; }
.side-scroll::-webkit-scrollbar-thumb { background: var(--border-glass); border-radius: 4px; }

.side-section-title {
    font-size: .75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 700;
    color: var(--primary-glow);
    margin-top: 1.2rem;
    margin-bottom: .6rem;
}
.side-text { font-size:.85rem; color:var(--text-muted); line-height: 1.5; }
.location-card {
    border-radius:12px; border:1px solid var(--border-glass);
    padding:.8rem; margin-bottom:.6rem; background:rgba(15,23,42,0.4);
    transition: 0.2s;
}
.location-card:hover { border-color: rgba(56,189,248,0.3); }
.location-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:.3rem; }
.location-name { font-size:.85rem; font-weight:600; color: #fff; }
.location-pill { font-size:.7rem; padding:.1rem .5rem; border-radius:999px; border:1px solid rgba(34,197,94,0.5); color:#bbf7d0; }

/* Responsive */
@media (max-width: 992px) {
    #bizRoot.focus-mode .main-layout {
        grid-template-columns: 1fr !important;
    }
    .side-panel {
        position: fixed;
        inset: 0;
        top: 0;
        height: 100vh;
        max-height: none;
        border-radius: 0;
        z-index: 1000;
        margin-top: 0;
    }
    .grid-businesses {
        /* On mobile, don't squish */
        grid-template-columns: 1fr;
    }
}
</style>

<div class="dashboard-root" id="bizRoot" data-theme="dark">
    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center mb-4" role="alert"
             style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);color:#4ade80;border-radius:12px;">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- Hero --}}
    <div class="hero-header">
        <div class="hero-inner">
            <div>
                <h1 class="hero-title">Business Empire</h1>
                <p class="hero-sub">
                    Manage your locations, track performance, and create exclusive deals to grow your brand presence.
                </p>
                <div class="stats-row">
                    <div class="stat-badge">
                        <i class="bi bi-briefcase-fill"></i>
                        <span><strong>{{ $businesses->count() }}</strong> Businesses</span>
                    </div>
                    <div class="stat-badge">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span><strong>{{ $businesses->sum(fn($b) => $b->locations->count()) }}</strong> Locations</span>
                    </div>
                    <div class="stat-badge">
                        <i class="bi bi-patch-check-fill text-warning"></i>
                        <span><strong>{{ $businesses->where('is_verified', 1)->count() }}</strong> Verified</span>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column align-items-end gap-3">
                <div class="theme-toggle" id="themeToggle">
                    <span class="d-none d-md-inline">Theme</span>
                    <div class="theme-switch">
                        <div class="theme-knob"></div>
                    </div>
                    <i class="bi bi-moon-stars-fill d-none" id="iconDark"></i>
                    <i class="bi bi-sun-fill d-inline" id="iconLight"></i>
                </div>
                <a href="{{ route('business.create') }}" class="btn-premium">
                    <span class="fs-5 lh-1">+</span>
                    <span>Launch New Business</span>
                </a>
            </div>
        </div>
    </div>

    {{-- MAIN: grid + side panel --}}
    <div class="main-layout" id="mainLayout">
        <div>
            @if($businesses->count() > 0)
                <div class="grid-businesses">
                    @foreach($businesses as $index => $business)
                        @php $primaryLocation = $business->locations->where('is_primary', 1)->first(); @endphp
                        <div class="biz-card"
                             style="animation-delay: {{ $index * 0.08 }}s;"
                             data-id="{{ $business->id }}"
                             data-name="{{ $business->business_name }}"
                             data-category="{{ $business->category->name ?? 'General' }}"
                             data-status="{{ $business->status ?? 'Active' }}"
                             data-email="{{ $business->email ?? '' }}"
                             data-phone="{{ $business->phone ?? '' }}"
                             data-desc="{{ $business->description ?? '' }}"
                             data-logo="{{ $business->logo_url ? Storage::url($business->logo_url) : '' }}">
                            {{-- Image --}}
                            <div class="card-img-wrapper">
                                <div class="card-gradient-overlay"></div>
                                <div class="card-status">
                                    <div class="status-dot"></div> {{ $business->status ?? 'Active' }}
                                </div>

                                @if($business->logo_url)
                                    <img src="{{ Storage::url($business->logo_url) }}" alt="{{ $business->business_name }}">
                                @else
                                    <div style="width:100%;height:100%;background:linear-gradient({{ ($business->id * 45) % 360 }}deg,#0f172a,#1e293b);display:flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-buildings" style="font-size:3rem;color:rgba(255,255,255,0.1);"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Body --}}
                            <div class="card-content">
                                @if($business->category)
                                    <div class="biz-category">{{ $business->category->name }}</div>
                                @endif

                                <h3 class="biz-title text-truncate">{{ $business->business_name }}</h3>

                                <p class="biz-desc">
                                    {{ $business->description ?? 'No description provided for this business.' }}
                                </p>

                                <div class="location-strip">
                                    <i class="bi bi-geo-alt text-primary"></i>
                                    <span class="text-truncate">
                                        @if($primaryLocation)
                                            {{ $primaryLocation->city }}, {{ $primaryLocation->country }}
                                        @else
                                            Location Pending
                                        @endif
                                    </span>
                                </div>

                                <div class="card-actions-grid">
                                    {{-- Manage button triggers focus + side panel --}}
                                    <button type="button" class="action-link btn-manage"
                                            onclick="openBusinessPanel(event, {{ $business->id }})">
                                        <i class="bi bi-speedometer2"></i> Manage
                                    </button>

                                    <a href="{{ route('deals.create', ['business_id' => $business->id]) }}"
                                       class="action-link btn-deals">
                                        <i class="bi bi-ticket-perforated"></i> Deals
                                    </a>

                                    <div class="dropdown">
                                        <button class="action-link btn-menu" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="background:#1e293b;border:1px solid var(--border-glass);border-radius:12px;box-shadow:0 10px 40px rgba(0,0,0,0.5);">
                                            <li>
                                                <a class="dropdown-item p-2" href="{{ route('business.edit', $business->id) }}" style="color:#e2e8f0;">
                                                    <i class="bi bi-pencil me-2 text-warning"></i> Edit Details
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider bg-secondary opacity-25"></li>
                                            <li>
                                                <form action="{{ route('business.destroy', $business->id) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item p-2 text-danger w-100 text-start"
                                                            onclick="return confirm('Are you sure you want to delete this business?')">
                                                        <i class="bi bi-trash me-2"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div style="text-align:center;padding:4rem 2rem;background:var(--card-glass);border-radius:24px;border:1px dashed var(--border-glass);animation:float 6s ease-in-out infinite;">
                    <i class="bi bi-rocket-takeoff" style="font-size:5rem;background:linear-gradient(to bottom right,var(--primary-glow),var(--accent-glow));-webkit-background-clip:text;-webkit-text-fill-color:transparent;display:block;margin-bottom:1.5rem;"></i>
                    <h2 style="font-weight:800;color:var(--text-main);margin-bottom:1rem;">Your Empire Starts Here</h2>
                    <p class="text-muted mb-4" style="font-size:1.1rem;">
                        You haven't listed any businesses yet. Launch your first location to start managing deals and analytics.
                    </p>
                    <a href="{{ route('business.create') }}" class="btn-premium">
                        Create Your First Business
                    </a>
                </div>
            @endif
        </div>

        {{-- SIDE PANEL (Section 2) --}}
        <aside class="side-panel" id="sidePanel">
            <div class="side-header">
                <div>
                    <div class="side-title">Business overview</div>
                    <div class="side-text" id="panelSubtitle">Select a business to view details.</div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <div class="dropdown">
                        <button class="btn-close-panel" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end"
                            style="background:#1e293b;border:1px solid var(--border-glass);border-radius:12px;box-shadow:0 10px 40px rgba(0,0,0,0.5);">
                            
                            <li>
                                <a class="dropdown-item p-2" id="panelEditBtn" href="#" style="color:#e2e8f0;">
                                    <i class="bi bi-pencil me-2 text-warning"></i> Edit Details
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item p-2" id="panelViewBtn" href="#" style="color:#e2e8f0;">
                                    <i class="bi bi-eye me-2 text-info"></i> View
                                </a>
                            </li>

                            <li><hr class="dropdown-divider bg-secondary opacity-25"></li>

                            <li>
                                <form id="panelDeleteForm" action="#" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="dropdown-item p-2 text-danger w-100 text-start"
                                            onclick="return confirm('Are you sure you want to delete this business?')">
                                        <i class="bi bi-trash me-2"></i> Delete
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <button class="btn-close-panel" type="button" onclick="closeBusinessPanel()">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>

            <div class="side-preview" id="panelPreview" style="display:none;">
                <div class="side-logo" id="panelLogo">
                    <i class="bi bi-buildings text-secondary"></i>
                </div>
                <div class="side-preview-text">
                    <h4 id="panelName">Business Name</h4>
                    <p id="panelCategory">Category</p>
                    <p id="panelStatus" class="side-text mb-0" style="font-size:0.75rem"></p>
                </div>
            </div>

            <div class="side-scroll" id="panelScroll">
                <div class="side-section-title">Description</div>
                <p class="side-text" id="panelDesc">—</p>

                <div class="side-section-title">Contact</div>
                <p class="side-text mb-1"><strong>Email:</strong> <span id="panelEmail">—</span></p>
                <p class="side-text mb-2"><strong>Phone:</strong> <span id="panelPhone">—</span></p>

                <div class="side-section-title">Locations</div>
                <div id="panelLocations">
                    <p class="side-text">No locations loaded.</p>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
// Theme logic
const root = document.getElementById('bizRoot');
const themeToggle = document.getElementById('themeToggle');
const iconDark = document.getElementById('iconDark');
const iconLight = document.getElementById('iconLight');

themeToggle.addEventListener('click', () => {
    const current = root.getAttribute('data-theme') || 'dark';
    const next = current === 'dark' ? 'light' : 'dark';
    root.setAttribute('data-theme', next);
    if (next === 'dark') {
        iconDark.classList.add('d-none');
        iconLight.classList.remove('d-none');
    } else {
        iconDark.classList.remove('d-none');
        iconLight.classList.add('d-none');
    }
});

function openBusinessPanel(e, id) {
    e.stopPropagation();
    const card = document.querySelector('.biz-card[data-id="'+id+'"]');
    if (!card) return;

    // ADD FOCUS MODE TO ROOT
    root.classList.add('focus-mode');
    
    // Focus THIS card only
    document.querySelectorAll('.biz-card').forEach(c => c.classList.remove('is-focused'));
    card.classList.add('is-focused');

    // Fill panel with data
    const name = card.dataset.name || 'Business';
    const cat  = card.dataset.category || 'General';
    const status = card.dataset.status || 'Active';
    const email = card.dataset.email || '—';
    const phone = card.dataset.phone || '—';
    const desc  = card.dataset.desc || 'No description provided.';
    const logo  = card.dataset.logo || '';

    // UPDATE SIDEBAR BUTTONS LINKS
    document.getElementById('panelEditBtn').href = "/business/" + id + "/edit";
    document.getElementById('panelViewBtn').href = "/business/" + id;
    document.getElementById('panelDeleteForm').action = "/business/" + id;

    // Update Text Fields
    document.getElementById('panelSubtitle').textContent = 'Overview for business #' + id;
    const preview = document.getElementById('panelPreview');
    preview.style.display = 'flex';
    document.getElementById('panelName').textContent = name;
    document.getElementById('panelCategory').textContent = cat;
    document.getElementById('panelStatus').textContent = 'Status: ' + status;
    document.getElementById('panelDesc').textContent = desc;
    document.getElementById('panelEmail').textContent = email;
    document.getElementById('panelPhone').textContent = phone;

    // Logo Update
    const logoWrap = document.getElementById('panelLogo');
    logoWrap.innerHTML = '';
    if (logo) {
        const img = document.createElement('img');
        img.src = logo;
        img.alt = name;
        logoWrap.appendChild(img);
    } else {
        logoWrap.innerHTML = '<i class="bi bi-buildings text-secondary"></i>';
    }

    // Locations Data Injection
    const allLocations = {!! json_encode(
        $businesses->mapWithKeys(function($b) {
            return [$b->id => $b->locations->map(function($l) {
                return [
                    'branch_name' => $l->branch_name,
                    'city' => $l->city,
                    'country' => $l->country,
                    'address' => $l->address,
                    'is_primary' => (bool) $l->is_primary,
                ];
            })->toArray()];
        })->toArray()
    ) !!};
    
    const locWrapper = document.getElementById('panelLocations');
    locWrapper.innerHTML = '';
    const locs = allLocations[id] || [];
    if (!locs.length) {
        locWrapper.innerHTML = '<p class="side-text">No locations added yet.</p>';
    } else {
        locs.forEach(loc => {
            const div = document.createElement('div');
            div.className = 'location-card';
            div.innerHTML = `
                <div class="location-head">
                    <span class="location-name">${loc.branch_name}</span>
                    ${loc.is_primary ? '<span class="location-pill">Primary</span>' : ''}
                </div>
                <div class="side-text">
                    <i class="bi bi-geo-alt me-1"></i>${loc.city}, ${loc.country}
                </div>
                <div class="side-text">${loc.address}</div>
            `;
            locWrapper.appendChild(div);
        });
    }
}

function closeBusinessPanel() {
    root.classList.remove('focus-mode');
    document.querySelectorAll('.biz-card').forEach(c => c.classList.remove('is-focused'));
}
</script>
@endsection