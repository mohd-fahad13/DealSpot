@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* * ==========================================
     * THEME CONFIGURATION
     * ==========================================
     */
    :root {
        /* --- LIGHT MODE VARIABLES (Your Original Style) --- */
        --font-main: 'Inter', system-ui, -apple-system, sans-serif;
        --bg-body: #f3f4f6;
        --bg-hero: #ffffff;
        --bg-card: #ffffff;
        --text-main: #1f2937;
        --text-sub: #6b7280;
        --border-color: rgba(0,0,0,0.05);
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        --card-hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --hero-shadow: 0 4px 20px rgba(0,0,0,0.05);
        
        /* Gradients (Shared/Light) */
        --primary-gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        --secondary-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
        
        /* Elements */
        --icon-bg: rgba(255,255,255,0.2);
        --badge-bg-indigo: #e0e7ff;
        --badge-text-indigo: #4338ca;
        
        /* Transition for smooth toggle */
        --theme-transition: background-color 0.4s ease, color 0.4s ease, border-color 0.4s ease, box-shadow 0.4s ease;
    }

    /* --- DARK MODE OVERRIDES (The New Premium Style) --- */
    body.dark-mode {
        --font-main: 'Plus Jakarta Sans', sans-serif;
        --bg-body: #0f172a; /* Deep Navy */
        --bg-hero: rgba(30, 41, 59, 0.7); /* Glass */
        --bg-card: rgba(30, 41, 59, 0.6); /* Glass */
        --text-main: #f8fafc;
        --text-sub: #94a3b8;
        --border-color: rgba(255, 255, 255, 0.08);
        --card-shadow: none;
        --card-hover-shadow: 0 20px 40px -10px rgba(0,0,0,0.5);
        --hero-shadow: 0 1px 0 0 rgba(255,255,255,0.05);

        /* Elements */
        --icon-bg: rgba(255,255,255,0.1);
        --badge-bg-indigo: rgba(99, 102, 241, 0.15);
        --badge-text-indigo: #818cf8;
    }

    /* Special Background for Dark Mode only */
    body.dark-mode::before {
        content: '';
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background-image: 
            radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.1) 0px, transparent 50%),
            radial-gradient(at 100% 0%, rgba(16, 185, 129, 0.1) 0px, transparent 50%);
        z-index: -1;
        pointer-events: none;
    }

    body {
        background-color: var(--bg-body);
        font-family: var(--font-main);
        color: var(--text-main);
        transition: var(--theme-transition);
        min-height: 100vh;
    }

    /* --- Toggle Button Styles --- */
    .theme-toggle-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 55px;
        height: 55px;
        border-radius: 50%;
        border: none;
        background: var(--bg-card);
        color: var(--text-main);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        cursor: pointer;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
    }

    .theme-toggle-btn:hover {
        transform: scale(1.1) rotate(15deg);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }

    /* --- Animations --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-entry {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }

    /* --- Layout Components --- */
    
    .dashboard-hero {
        background: var(--bg-hero);
        padding: 2.5rem 2rem;
        border-bottom-left-radius: 2rem;
        border-bottom-right-radius: 2rem;
        box-shadow: var(--hero-shadow);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        transition: var(--theme-transition);
        backdrop-filter: blur(20px); /* For dark mode glass */
        -webkit-backdrop-filter: blur(20px);
    }

    /* The gradient circle in Hero (Light Mode Only) */
    .hero-bg-decoration {
        position: absolute;
        top: -50px; right: -50px;
        width: 200px; height: 200px;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
        border-radius: 50%;
        z-index: 0;
        opacity: 1;
        transition: opacity 0.4s;
    }
    body.dark-mode .hero-bg-decoration { opacity: 0; } /* Hide in dark mode */

    .hero-content { position: relative; z-index: 1; }

    /* --- Action Cards --- */
    .action-card {
        border: none;
        border-radius: 1.5rem;
        color: white !important;
        padding: 2rem;
        height: 100%;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-decoration: none !important;
        display: block;
    }

    .action-bg-business { background: var(--primary-gradient); }
    .action-bg-deal { background: var(--secondary-gradient); }

    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    
    /* Extra Glow for Dark Mode Hover */
    body.dark-mode .action-card:hover {
        box-shadow: 0 20px 40px -10px rgba(99, 102, 241, 0.4);
    }

    .action-icon-circle {
        background: var(--icon-bg);
        width: 60px; height: 60px;
        border-radius: 50%; /* Circle in Light */
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 1.5rem;
        backdrop-filter: blur(5px);
        transition: all 0.3s;
    }

    /* Dark mode makes icons slightly squared (Modern look) */
    body.dark-mode .action-icon-circle { border-radius: 16px; } 

    /* --- Info Cards --- */
    .info-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 1.25rem;
        padding: 2rem;
        height: 100%;
        box-shadow: var(--card-shadow);
        transition: var(--theme-transition);
        backdrop-filter: blur(10px);
    }

    .info-card:hover {
        border-color: #6366f1;
        box-shadow: var(--card-hover-shadow);
        transform: translateY(-3px);
    }

    .icon-square {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    /* Utility Classes for Icons/Badges */
    .bg-light-indigo { background-color: #e0e7ff; color: #4338ca; }
    .bg-light-emerald { background-color: #d1fae5; color: #047857; }
    .bg-light-orange { background-color: #ffedd5; color: #c2410c; }

    /* Dark Mode specific colors for utility classes */
    body.dark-mode .bg-light-indigo { background: rgba(99, 102, 241, 0.15); color: #818cf8; }
    body.dark-mode .bg-light-emerald { background: rgba(16, 185, 129, 0.15); color: #34d399; }
    body.dark-mode .bg-light-orange { background: rgba(249, 115, 22, 0.15); color: #fb923c; }

    .badge-custom {
        background: var(--badge-bg-indigo);
        color: var(--badge-text-indigo);
    }

    /* Typography helpers */
    .text-gradient {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .text-heading { color: var(--text-main); }
    .text-sub { color: var(--text-sub); }
</style>

<div class="min-vh-100 pb-5">
    
    {{-- Theme Toggle Button --}}
    <button id="themeToggle" class="theme-toggle-btn" title="Switch Theme">
        <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
    </button>

    {{-- Hero Section --}}
    <div class="dashboard-hero animate-entry">
        <div class="hero-bg-decoration"></div>
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge badge-custom px-3 py-2 rounded-pill fw-bold small me-3">
                            BUSINESS OWNER PORTAL
                        </span>
                        <span class="text-sub small"><i class="bi bi-calendar-event me-1"></i> Today: {{ date('F j, Y') }}</span>
                    </div>
                    <h1 class="display-5 fw-bold text-heading mb-2">
                        Hello, <span class="text-gradient">{{ session('$owner->name') }}</span>
                    </h1>       
                    <p class="lead text-sub mb-0" style="font-size: 1.1rem;">
                        Here is what’s happening with your businesses and deals today.
                    </p>
                </div>
                
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <form action="{{ route('owner.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-outline-danger px-4 py-2 rounded-pill fw-semibold border-2">
                            <i class="bi bi-box-arrow-right me-2"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 animate-entry">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-0">Success!</h6>
                        <small>{{ session('success') }}</small>
                    </div>
                </div>
            </div>
        @endif

        {{-- Action Cards --}}
        <div class="row g-4 mb-5">
            <div class="col-md-6 animate-entry delay-1">
                <a href="{{ route('business.create') }}" class="action-card action-bg-business">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="action-icon-circle">
                                <i class="bi bi-shop fs-3"></i>
                            </div>
                            <h3 class="fw-bold mb-1">Add Business</h3>
                            <p class="mb-0 opacity-75">Register a new shop or branch.</p>
                        </div>
                        <i class="bi bi-arrow-right-circle fs-1 opacity-50"></i>
                    </div>
                </a>
            </div>

            <div class="col-md-6 animate-entry delay-2">
                <a href="{{ route('deals.create') }}" class="action-card action-bg-deal">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="action-icon-circle">
                                <i class="bi bi-ticket-perforated-fill fs-3"></i>
                            </div>
                            <h3 class="fw-bold mb-1">Create Deals</h3>
                            <p class="mb-0 opacity-75">Post a new offer to attract customers.</p>
                        </div>
                        <i class="bi bi-plus-circle-fill fs-1 opacity-50"></i>
                    </div>
                </a>
            </div>
        </div>

        {{-- Overview Header --}}
        <div class="row mb-3 animate-entry delay-2">
            <div class="col-12"><h4 class="fw-bold text-heading mb-3">Overview</h4></div>
        </div>

        {{-- Info Cards --}}
        <div class="row g-4">
            
            <div class="col-md-4 animate-entry delay-3">
                <div class="info-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-square bg-light-indigo">
                            <i class="bi bi-building"></i>
                        </div>
                        <span class="badge bg-light text-dark rounded-pill border">Active</span>
                    </div>
                    <h5 class="fw-bold text-heading">My Businesses</h5>
                    <p class="text-sub small mb-4">Manage locations, contact info, and business details.</p>
                    <a href="{{ route('business.showAll') }}" class="btn btn-link text-decoration-none p-0 fw-bold text-primary">
                        View Details <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-4 animate-entry delay-3">
                <div class="info-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-square bg-light-emerald">
                            <i class="bi bi-tags-fill"></i>
                        </div>
                        <span class="badge bg-light text-dark rounded-pill border">Live</span>
                    </div>
                    <h5 class="fw-bold text-heading">Active Deals</h5>
                    <p class="text-sub small mb-4">Track performance of your current coupons and offers.</p>
                    <a href="{{ route('deals.showAll') }}" class="btn btn-link text-decoration-none p-0 fw-bold text-success">
                        Manage Offers <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-4 animate-entry delay-3">
                <div class="info-card position-relative overflow-hidden">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-square bg-light-orange">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">Soon</span>
                    </div>
                    <h5 class="fw-bold text-heading">Customer Reach</h5>
                    <p class="text-sub small mb-4">Analyze views, clicks, and customer engagement.</p>
                    <button class="btn btn-light btn-sm w-100 disabled" style="opacity: 0.6">
                        Coming Soon
                    </button>
                    <i class="bi bi-bar-chart-line position-absolute bottom-0 end-0 text-sub opacity-10" style="font-size: 8rem; margin-bottom: -2rem; margin-right: -1rem;"></i>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const body = document.body;

        // 1. Check LocalStorage on Load
        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark-mode');
            themeIcon.classList.remove('bi-moon-stars-fill');
            themeIcon.classList.add('bi-sun-fill');
        }

        // 2. Toggle Function
        toggleBtn.addEventListener('click', function() {
            body.classList.toggle('dark-mode');

            if (body.classList.contains('dark-mode')) {
                // Switched to Dark
                localStorage.setItem('theme', 'dark');
                themeIcon.classList.remove('bi-moon-stars-fill');
                themeIcon.classList.add('bi-sun-fill');
            } else {
                // Switched to Light
                localStorage.setItem('theme', 'light');
                themeIcon.classList.remove('bi-sun-fill');
                themeIcon.classList.add('bi-moon-stars-fill');
            }
        });
    });
</script>

@endsection

