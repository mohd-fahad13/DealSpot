@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root {
    --bg-deep: #020617;
    --bg-surface: #0f172a;
    --primary-glow: #f59e0b; /* Golden orange for deals */
    --secondary-glow: #ef4444; /* Red accent */
    --accent-glow: #10b981; /* Green success */
    --text-main: #f8fafc;
    --text-muted: #94a3b8;
    --card-glass: rgba(30, 41, 59, 0.8);
    --border-glass: rgba(255, 255, 255, 0.08);
}

/* Light mode */
[data-theme="light"] {
    --bg-deep: #fef3c7;
    --bg-surface: #ffffff;
    --card-glass: rgba(255,255,255,0.95);
    --border-glass: rgba(251, 191, 36, 0.2);
    --text-main: #1f2937;
    --text-muted: #6b7280;
}

/* Base */
body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: linear-gradient(135deg, var(--bg-deep) 0%, var(--bg-surface) 50%);
    min-height: 100vh;
    color: var(--text-main);
    overflow-x: hidden;
    position: relative;
}

/* Floating particles animation */
body::before {
    content: '';
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    pointer-events: none;
    z-index: -1;
    background-image: 
        radial-gradient(circle at 20% 80%, rgba(245,158,11,0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(239,68,68,0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(16,185,129,0.08) 0%, transparent 50%);
    animation: particleFloat 20s ease-in-out infinite;
}

@keyframes particleFloat {
    0%, 100% { transform: translateY(0) scale(1); opacity: 0.6; }
    50% { transform: translateY(-20px) scale(1.1); opacity: 1; }
}

/* Animations */
@keyframes fadeSlideUp { from {opacity:0; transform:translateY(30px);} to {opacity:1; transform:translateY(0);} }
@keyframes pulseDeal {0%{box-shadow:0 0 0 0 rgba(245,158,11,0.5);}70%{box-shadow:0 0 0 20px rgba(245,158,11,0);}100%{box-shadow:0 0 0 0 rgba(245,158,11,0);}}
@keyframes floatDeal {0%,100%{transform:translateY(0) rotate(0deg);}50%{transform:translateY(-10px) rotate(2deg);}}
@keyframes shimmer {0%{background-position:-200% 0;}100%{background-position:200% 0;}}

/* Layout */
.dashboard-root {
    max-width: 1440px; margin: 0 auto; padding: 2rem 1.5rem 4rem;
}

.hero-header {
    position: relative; margin-bottom: 2.5rem; padding: 2.4rem 2.2rem;
    border-radius: 24px; background: linear-gradient(135deg, rgba(15,23,42,0.95), rgba(30,41,59,0.8));
    border: 1px solid var(--border-glass); backdrop-filter: blur(20px); overflow: hidden;
    animation: fadeSlideUp 0.8s ease-out;
}
.hero-header::before {
    content:''; position:absolute; top:0;left:0;right:0;height:1px;
    background:linear-gradient(90deg,transparent,var(--primary-glow),var(--accent-glow),transparent); opacity:.6;
}
.hero-inner {position:relative; z-index:1; display:flex; flex-wrap:wrap; gap:1.5rem; justify-content:space-between; align-items:flex-start;}
.hero-title {
    font-size:2.6rem; font-weight:800; background:linear-gradient(to right,var(--primary-glow),var(--accent-glow));
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; letter-spacing:-1px; margin-bottom:.6rem;
}
.hero-sub {color:var(--text-muted); max-width:600px;}
.stats-row {display:flex; gap:1rem; margin-top:1.2rem; flex-wrap:wrap;}
.stat-badge {
    display:flex; align-items:center; gap:.6rem; padding:.55rem 1.1rem;
    background:rgba(255,255,255,0.03); border:1px solid var(--border-glass); border-radius:100px;
    font-size:.85rem; color:var(--text-muted); animation: pulseDeal 3s infinite;
}
.stat-badge strong {color:var(--text-main); font-weight:700;}
.stat-badge i {color:var(--primary-glow); font-size:1.1rem;}

.btn-premium {
    padding:.85rem 1.7rem; background:linear-gradient(135deg,var(--primary-glow),var(--secondary-glow));
    color:#fff; border:none; border-radius:12px; font-weight:700; font-size:.95rem; text-decoration:none;
    display:inline-flex; align-items:center; gap:.6rem; box-shadow:0 10px 30px -10px rgba(245,158,11,0.5);
    transition:all .3s; position:relative; overflow:hidden;
}
.btn-premium::before {
    content:''; position:absolute; inset:0; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.3),transparent);
    transform:translateX(-100%); transition:transform .6s;
}
.btn-premium:hover::before {transform:translateX(100%);}
.btn-premium:hover {transform:translateY(-3px); box-shadow:0 18px 40px -10px rgba(245,158,11,0.7); color:#fff;}

/* Main Layout */
.main-layout {
    display: grid; grid-template-columns: 1fr; gap: 2rem; align-items: start; min-height: 50vh;
    transition: grid-template-columns 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

/* Focus Mode */
#dealRoot.focus-mode .main-layout {grid-template-columns: 380px 1fr !important; gap: 1.5rem !important;}
#dealRoot.focus-mode .grid-deals {grid-template-columns: 1fr !important; display: flex; flex-direction: column; gap: 1rem;}
#dealRoot.focus-mode .side-panel {opacity: 1; pointer-events: auto; transform: translateX(0);}
#dealRoot.focus-mode .deal-card.is-focused {
    transform: scale(1.02); border-color: var(--primary-glow);
    box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.3), 0 20px 40px rgba(0,0,0,0.4);
}
#dealRoot.focus-mode .deal-card:not(.is-focused) {opacity: 0.6; transform: scale(0.98);}
#dealRoot.focus-mode .deal-card:not(.is-focused):hover {opacity: 1; transform: scale(1);}

/* Deal Cards */
.grid-deals {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.6rem; width: 100%;
}
.deal-card {
    background: var(--card-glass); border: 1px solid var(--border-glass); border-radius: 20px; overflow: hidden;
    position: relative; backdrop-filter: blur(12px); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    animation: fadeSlideUp 0.6s ease-out backwards, floatDeal 6s ease-in-out infinite;
    display: flex; flex-direction: column;
}
.deal-card:hover:not(.is-focused) {
    transform: translateY(-8px); border-color: rgba(245,158,11,0.4);
    box-shadow: 0 25px 50px rgba(15,23,42,0.8);
}

/* Deal Image */
.deal-img-wrapper {height: 220px; position: relative; overflow: hidden;}
#dealRoot.focus-mode .deal-img-wrapper {height: 160px;}
.deal-img-wrapper img {
    width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s ease;
}
.deal-card:hover .deal-img-wrapper img {transform: scale(1.08);}
.deal-gradient-overlay {position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); z-index: 1;}

/* Status Badge */
.deal-status {
    position: absolute; top: 1rem; right: 1rem; z-index: 2; padding: 0.4rem 0.9rem;
    background: rgba(15,23,42,0.9); backdrop-filter: blur(8px); border: 1px solid rgba(16,185,129,0.3);
    border-radius: 100px; color: var(--accent-glow); font-size: 0.75rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .5px; display: flex; align-items: center; gap: 6px;
    animation: pulseDeal 2s infinite;
}
.status-dot {width: 8px; height: 8px; background: var(--accent-glow); border-radius: 50%;}

/* Discount Badge */
.discount-badge {
    position: absolute; top: 1rem; left: 1rem; z-index: 2; padding: 0.6rem 1.2rem;
    background: linear-gradient(135deg, var(--primary-glow), var(--secondary-glow));
    border-radius: 12px; color: white; font-weight: 800; font-size: 1.1rem;
    box-shadow: 0 8px 25px rgba(245,158,11,0.4); animation: shimmer 2s infinite linear;
    background-size: 200% 100%;
}

/* Card Content */
.card-content {padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; position: relative; z-index: 2;}
.deal-business {color: var(--primary-glow); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; margin-bottom: 0.4rem;}
.deal-title {font-size: 1.35rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.8rem; line-height: 1.3;}
.deal-meta {
    display: flex; gap: 1rem; margin-bottom: 1rem; color: var(--text-muted); font-size: 0.9rem;
}
.deal-meta i {color: var(--accent-glow); width: 16px;}
.deal-desc {color: var(--text-muted); font-size: 0.92rem; line-height: 1.6; margin-bottom: 1.2rem; flex-grow: 1;}

/* Actions */
.card-actions-grid {
    display: grid; grid-template-columns: 1fr 1fr auto; gap: 0.6rem; margin-top: auto; padding-top: 1rem;
    border-top: 1px solid var(--border-glass);
}
.action-link {
    padding: 0.75rem; border-radius: 12px; font-size: 0.85rem; font-weight: 600; text-align: center;
    text-decoration: none; transition: 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 0.4rem;
}
.btn-manage {background: rgba(255,255,255,0.08); color: var(--text-main); border: 1px solid var(--border-glass);}
.btn-manage:hover {background: rgba(255,255,255,0.15); border-color: var(--primary-glow); transform: translateY(-1px);}
.btn-stats {background: rgba(16,185,129,0.15); color: var(--accent-glow); border: 1px solid rgba(16,185,129,0.3);}
.btn-menu {width: 44px; background: transparent; border: 1px solid var(--border-glass); color: var(--text-muted);}

/* Side Panel */
.side-panel {
    background: var(--card-glass); border-radius: 24px; border: 1px solid var(--border-glass);
    backdrop-filter: blur(18px); padding: 1.8rem; position: sticky; top: 2rem; height: calc(100vh - 4rem);
    display: flex; flex-direction: column; opacity: 0; pointer-events: none; transform: translateX(20px);
    transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94); overflow: hidden; max-height: 800px;
    animation: floatDeal 4s ease-in-out infinite;
}
.side-header {
    display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; padding-bottom:1rem;
    border-bottom: 1px solid var(--border-glass);
}
.side-title {font-size:1rem; font-weight:700;}
.btn-close-panel {border:none; background:transparent; color:var(--text-muted); cursor:pointer; padding:.4rem; border-radius:8px;}
.btn-close-panel:hover {background:rgba(255,255,255,0.1); color:var(--text-main);}

.side-preview {
    display:flex; gap:1rem; border-radius:16px; border:1px solid var(--border-glass); padding:1rem; margin-bottom:1.5rem;
    background: rgba(245,158,11,0.1); position: relative; overflow: hidden;
}
.side-preview::before {
    content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(245,158,11,0.1),transparent);
    animation: shimmer 3s infinite linear;
}
.side-logo {width:64px; height:64px; border-radius:16px; overflow:hidden; background:linear-gradient(135deg,var(--primary-glow),var(--secondary-glow));}
.side-logo img {width:100%; height:100%; object-fit:cover;}
.side-preview-text h4 {font-size:1.1rem; margin-bottom:.3rem; background:linear-gradient(135deg,var(--primary-glow),var(--text-main)); -webkit-background-clip:text; -webkit-text-fill-color:transparent;}
.side-preview-text p {font-size:.85rem; margin-bottom:.2rem; color:var(--text-muted);}

.side-scroll {overflow-y: auto; padding-right: .5rem; flex: 1;}
.side-scroll::-webkit-scrollbar {width: 4px;}
.side-scroll::-webkit-scrollbar-track {background: transparent;}
.side-scroll::-webkit-scrollbar-thumb {background: var(--border-glass); border-radius: 4px;}

.side-section-title {
    font-size: .8rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;
    color: var(--primary-glow); margin-top: 1.5rem; margin-bottom: .8rem;
}
.side-text {font-size:.88rem; color:var(--text-muted); line-height: 1.5;}
.detail-row {display:flex; justify-content:space-between; align-items:center; padding:.6rem 0; border-bottom:1px solid var(--border-glass);}
.detail-label {font-weight:600; color:var(--text-main);}
.detail-value {color:var(--primary-glow); font-weight:500;}

/* Responsive */
@media (max-width: 992px) {
    #dealRoot.focus-mode .main-layout {grid-template-columns: 1fr !important;}
    .side-panel {
        position: fixed; inset: 0; top: 0; height: 100vh; max-height: none; border-radius: 0; z-index: 1000;
    }
    .grid-deals {grid-template-columns: 1fr;}
}
</style>

<div class="dashboard-root" id="dealRoot" data-theme="dark">
    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center mb-4" role="alert"
             style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);color:#059669;border-radius:16px;animation:pulseDeal 2s infinite;">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Hero --}}
    <div class="hero-header">
        <div class="hero-inner">
            <div>
                <h1 class="hero-title">Deal Dashboard</h1>
                <p class="hero-sub">Your exclusive discount campaigns. Track performance, manage offers, and drive customer engagement.</p>
                <div class="stats-row">
                    <div class="stat-badge">
                        <i class="bi bi-ticket-perforated"></i>
                        <span><strong>{{ $deals->count() }}</strong> Active Deals</span>
                    </div>
                    <div class="stat-badge">
                        <i class="bi bi-shop"></i>
                        <span><strong>{{ $deals->groupBy('business_id')->count() }}</strong> Businesses</span>
                    </div>
                    <div class="stat-badge">
                        <i class="bi bi-fire" style="color: var(--secondary-glow);"></i>
                        <span><strong>{{ $deals->where('status', 'active')->count() }}</strong> Live</span>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column align-items-end gap-3">
                <div class="theme-toggle" id="themeToggle">
                    <span class="d-none d-md-inline">Theme</span>
                    <div class="theme-switch"><div class="theme-knob"></div></div>
                    <i class="bi bi-moon-stars-fill d-none" id="iconDark"></i>
                    <i class="bi bi-sun-fill d-inline" id="iconLight"></i>
                </div>
                <a href="{{ route('deals.create') }}" class="btn-premium">
                    <span class="fs-5 lh-1">+</span> New Deal
                </a>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="main-layout">
        <div>
            @if($deals->count() > 0)
                <div class="grid-deals">
                    @foreach($deals as $index => $deal)
                        <div class="deal-card" style="animation-delay: {{ $index * 0.08 }}s;"
                             data-id="{{ $deal->id }}"
                             data-title="{{ $deal->title }}"
                             data-business="{{ $deal->business->business_name }}"
                             data-desc="{{ $deal->description }}"
                             data-discount-value="{{ $deal->discount_value }}"
                             data-discount-type="{{ $deal->discount_type }}"
                             data-start="{{ $deal->start_date }}"
                             data-end="{{ $deal->end_date }}"
                             data-min-purchase="{{ $deal->min_purchase }}"
                             data-promo="{{ $deal->promo_code }}"
                             data-status="{{ $deal->status }}"
                             data-image="{{ $deal->image_url ? Storage::url($deal->image_url) : '' }}">
                            
                            {{-- Image --}}
                            <div class="deal-img-wrapper">
                                <div class="deal-gradient-overlay"></div>
                                <div class="deal-status">
                                    <div class="status-dot"></div> {{ ucfirst($deal->status) }}
                                </div>
                                <div class="discount-badge">
                                    @if($deal->discount_type === 'percentage')
                                        {{ $deal->discount_value }}%
                                    @else
                                        ₹{{ number_format($deal->discount_value, 0) }}
                                    @endif
                                </div>
                                @if($deal->image_url)
                                    <img src="{{ Storage::url($deal->image_url) }}" alt="{{ $deal->title }}">
                                @else
                                    <div style="width:100%;height:100%;background:linear-gradient(135deg,var(--primary-glow),var(--secondary-glow));display:flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-percent" style="font-size:4rem;color:rgba(255,255,255,0.9);"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="card-content">
                                <div class="deal-business">{{ $deal->business->business_name }}</div>
                                <h3 class="deal-title text-truncate">{{ $deal->title }}</h3>
                                
                               @if($deal->description)
    <p class="deal-desc">{{ Str::limit($deal->description, 80) }}</p>
@endif

<div class="deal-meta">
    <span><i class="bi bi-calendar3"></i> {{ date('M d', strtotime($deal->start_date)) }} - {{ date('M d', strtotime($deal->end_date)) }}</span>
    @if($deal->promo_code)
        <span><i class="bi bi-tag"></i> {{ $deal->promo_code }}</span>
    @endif
</div>


                                <div class="card-actions-grid">
                                    <button type="button" class="action-link btn-manage" onclick="openDealPanel(event, {{ $deal->id }})">
                                        <i class="bi bi-gear"></i> Manage
                                    </button>
                                    <a href="{{ route('deals.showAll', $deal->id) }}" class="action-link btn-stats">
                                        <i class="bi bi-graph-up"></i> Stats
                                    </a>
                                    <!-- <div class="dropdown">
                                        <button class="action-link btn-menu" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="background:var(--bg-surface);border:1px solid var(--border-glass);border-radius:12px;box-shadow:0 15px 40px rgba(0,0,0,0.5);">
                                            <li><a class="dropdown-item p-3" href="{{ route('deals.showAll', $deal->id) }}" style="color:var(--text-main);"><i class="bi bi-pencil me-2"></i> Edit Deal</a></li>
                                            <li><hr class="dropdown-divider opacity-25"></li>
                                            <li>
                                                <form action="{{ route('deals.showAll', $deal->id) }}" method="POST" style="display:inline;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item p-3 text-danger w-100 text-start" onclick="return confirm('Delete this deal?')">
                                                        <i class="bi bi-trash me-2"></i> Delete Deal
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center;padding:6rem 2rem;background:var(--card-glass);border-radius:24px;border:2px dashed var(--border-glass);animation:floatDeal 5s ease-in-out infinite;">
                    <i class="bi bi-ticket-detailed" style="font-size:6rem;background:linear-gradient(135deg,var(--primary-glow),var(--accent-glow));-webkit-background-clip:text;-webkit-text-fill-color:transparent;display:block;margin-bottom:2rem;"></i>
                    <h2 style="font-weight:800;color:var(--text-main);margin-bottom:1.5rem;">No Deals Yet</h2>
                    <p class="text-muted mb-4" style="font-size:1.2rem;">Create your first exclusive offer to attract customers and boost sales!</p>
                    <a href="{{ route('deals.create') }}" class="btn-premium" style="font-size:1.1rem;padding:1rem 2.5rem;">
                        Launch First Deal
                    </a>
                </div>
            @endif
        </div>

        {{-- Side Panel --}}
        <aside class="side-panel" id="sidePanel">
            <!-- <div class="side-header">
                <div>
                    <div class="side-title">Deal Details</div>
                    <div class="side-text" id="panelSubtitle">Select a deal to view details</div>
                </div>
                <button class="btn-close-panel" onclick="closeDealPanel()">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div> -->
            <div class="side-header">
                <div>
                    <div class="side-title">Deal overview</div>
                    <div class="side-text" id="panelSubtitle">
                        Select a deal to view details.
                    </div>
                </div>

                <!-- Inside <aside class="side-panel" id="sidePanel"> -->

<div class="d-flex align-items-center gap-2">
    <!-- 3 DOTS MENU -->
    <div class="dropdown">
        <button class="btn-close-panel" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-three-dots-vertical"></i>
        </button>

        <ul class="dropdown-menu dropdown-menu-end"
            style="background:#1e293b;border:1px solid var(--border-glass);border-radius:12px;box-shadow:0 10px 40px rgba(0,0,0,0.5);">

            <li>
                <!-- Dynamic Edit Link -->
                <a class="dropdown-item p-2" id="sidebarEditLink" href="#" style="color:#e2e8f0;">
                    <i class="bi bi-pencil me-2 text-warning"></i> Edit Deal
                </a>
            </li>

            <li>
                <!-- Dynamic View Link -->
                <a class="dropdown-item p-2" id="sidebarViewLink" href="#" style="color:#e2e8f0;">
                    <i class="bi bi-eye me-2 text-info"></i> View Deal
                </a>
            </li>

            <li><hr class="dropdown-divider bg-secondary opacity-25"></li>

            <li>
                <!-- Dynamic Delete Form -->
                <form id="sidebarDeleteForm" action="#" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="dropdown-item p-2 text-danger w-100 text-start"
                            onclick="return confirm('Delete this deal?')">
                        <i class="bi bi-trash me-2"></i> Delete Deal
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- CLOSE BUTTON -->
    <button class="btn-close-panel" type="button" onclick="closeDealPanel()">
        <i class="bi bi-x-lg"></i>
    </button>
</div>

            </div>


            <div class="side-preview" id="panelPreview" style="display:none;">
                <div class="side-logo" id="panelLogo">
                    <i class="bi bi-percent text-white"></i>
                </div>
                <div class="side-preview-text">
                    <h4 id="panelTitle">Deal Title</h4>
                    <p id="panelBusiness">Business Name</p>
                    <p id="panelStatus" class="side-text mb-0"></p>
                </div>
            </div>

            <div class="side-scroll" id="panelScroll">
                <div class="side-section-title">Offer Details</div>
                <div class="detail-row">
                    <span class="detail-label">Discount</span>
                    <span class="detail-value" id="panelDiscount">-</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Min Purchase</span>
                    <span class="detail-value" id="panelMinPurchase">-</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Promo Code</span>
                    <span class="detail-value" id="panelPromo">-</span>
                </div>

                <div class="side-section-title">Timeline</div>
                <div class="detail-row">
                    <span class="detail-label">Valid From</span>
                    <span id="panelStart">-</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Valid Until</span>
                    <span id="panelEnd">-</span>
                </div>

                <div class="side-section-title">Description</div>
                <p class="side-text" id="panelDesc">-</p>
            </div>
        </aside>
    </div>
</div>

<script>
const root = document.getElementById('dealRoot');
const themeToggle = document.getElementById('themeToggle');
const iconDark = document.getElementById('iconDark');
const iconLight = document.getElementById('iconLight');

// Theme Toggle
themeToggle.addEventListener('click', () => {
    const current = root.getAttribute('data-theme') || 'dark';
    const next = current === 'dark' ? 'light' : 'dark';
    root.setAttribute('data-theme', next);
    if (next === 'dark') {
        iconDark.classList.add('d-none'); iconLight.classList.remove('d-none');
    } else {
        iconDark.classList.remove('d-none'); iconLight.classList.add('d-none');
    }
    localStorage.setItem('theme', next);
});

// Deal Panel Functions
function openDealPanel(e, id) {
    e.stopPropagation();
    const card = document.querySelector('.deal-card[data-id="'+id+'"]');
    if (!card) return;

    root.classList.add('focus-mode');
    document.querySelectorAll('.deal-card').forEach(c => c.classList.remove('is-focused'));
    card.classList.add('is-focused');

    // Fill panel data
    document.getElementById('panelSubtitle').textContent = 'Deal #' + id;
    const preview = document.getElementById('panelPreview');
    preview.style.display = 'flex';
    
    document.getElementById('panelTitle').textContent = card.dataset.title;
    document.getElementById('panelBusiness').textContent = card.dataset.business;
    document.getElementById('panelStatus').textContent = 'Status: ' + card.dataset.status;
    document.getElementById('panelDesc').textContent = card.dataset.desc || 'No description';
    
    // Discount formatting
    const type = card.dataset.discountType;
    const value = card.dataset.discountValue;
    document.getElementById('panelDiscount').textContent = type === 'percentage' ? value + '%' : '₹' + parseFloat(value).toLocaleString();
    
    document.getElementById('panelMinPurchase').textContent = card.dataset.minPurchase ? '₹' + parseFloat(card.dataset.minPurchase).toLocaleString() : 'None';
    document.getElementById('panelPromo').textContent = card.dataset.promo || 'None';
    document.getElementById('panelStart').textContent = new Date(card.dataset.start).toLocaleDateString();
    document.getElementById('panelEnd').textContent = new Date(card.dataset.end).toLocaleDateString();

    // Logo
    const logoWrap = document.getElementById('panelLogo');
    const imgUrl = card.dataset.image;
    logoWrap.innerHTML = '';
    if (imgUrl) {
        const img = document.createElement('img');
        img.src = imgUrl; img.alt = card.dataset.title;
        logoWrap.appendChild(img);
    } else {
        logoWrap.innerHTML = '<i class="bi bi-percent" style="font-size:2rem;color:white;"></i>';
    }
}

function closeDealPanel() {
    root.classList.remove('focus-mode');
    document.querySelectorAll('.deal-card').forEach(c => c.classList.remove('is-focused'));
}

// Load theme
const savedTheme = localStorage.getItem('theme') || 'dark';
root.setAttribute('data-theme', savedTheme);
if (savedTheme === 'dark') {
    iconDark.classList.add('d-none'); iconLight.classList.remove('d-none');
} else {
    iconDark.classList.remove('d-none'); iconLight.classList.add('d-none');
}

function openDealPanel(e, id) {
    e.stopPropagation();
    const card = document.querySelector('.deal-card[data-id="'+id+'"]');
    if (!card) return;

    root.classList.add('focus-mode');
    document.querySelectorAll('.deal-card').forEach(c => c.classList.remove('is-focused'));
    card.classList.add('is-focused');

    // --- NEW CODE: Update Sidebar Action Links ---
    
    // 1. Update Edit Link
    const editLink = document.getElementById('sidebarEditLink');
    if(editLink) {
        // Construct the route dynamically. 
        // Assuming your route is /deals/{id}/edit or similar.
        // Best way is to use a base URL placeholder if you can, 
        // or just construct it if you know the structure.
        editLink.href = "/deals/" + id + "/edit"; 
    }

    // 2. Update View Link
    const viewLink = document.getElementById('sidebarViewLink');
    if(viewLink) {
        viewLink.href = "/deals/" + id; // Assuming route is /deals/{id}
    }

    // 3. Update Delete Form Action
    const deleteForm = document.getElementById('sidebarDeleteForm');
    if(deleteForm) {
        deleteForm.action = "/deals/" + id; // Assuming route is /deals/{id} for DELETE
    }

    // --- END NEW CODE ---

    // Fill panel data
    document.getElementById('panelSubtitle').textContent = 'Deal #' + id;
    const preview = document.getElementById('panelPreview');
    preview.style.display = 'flex';
    
    document.getElementById('panelTitle').textContent = card.dataset.title;
    document.getElementById('panelBusiness').textContent = card.dataset.business;
    document.getElementById('panelStatus').textContent = 'Status: ' + card.dataset.status;
    document.getElementById('panelDesc').textContent = card.dataset.desc || 'No description';
    
    // Discount formatting
    const type = card.dataset.discountType;
    const value = card.dataset.discountValue;
    document.getElementById('panelDiscount').textContent = type === 'percentage' ? value + '%' : '₹' + parseFloat(value).toLocaleString();
    
    document.getElementById('panelMinPurchase').textContent = card.dataset.minPurchase ? '₹' + parseFloat(card.dataset.minPurchase).toLocaleString() : 'None';
    document.getElementById('panelPromo').textContent = card.dataset.promo || 'None';
    document.getElementById('panelStart').textContent = new Date(card.dataset.start).toLocaleDateString();
    document.getElementById('panelEnd').textContent = new Date(card.dataset.end).toLocaleDateString();

    // Logo
    const logoWrap = document.getElementById('panelLogo');
    const imgUrl = card.dataset.image;
    logoWrap.innerHTML = '';
    if (imgUrl) {
        const img = document.createElement('img');
        img.src = imgUrl; img.alt = card.dataset.title;
        logoWrap.appendChild(img);
    } else {
        logoWrap.innerHTML = '<i class="bi bi-percent" style="font-size:2rem;color:white;"></i>';
    }
}

</script>
@endsection
