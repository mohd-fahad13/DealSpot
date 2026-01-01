<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'DealSpot - Local Business Deals' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* --- GLOBAL VARIABLES (Matches Dashboard Theme) --- */
        :root {
            --primary-color: #4f46e5;       /* Indigo */
            --primary-hover: #4338ca;
            --secondary-color: #10b981;     /* Emerald */
            --dark-bg: #0f172a;             /* Slate 900 */
            --light-bg: #f8fafc;            /* Slate 50 */
            --glass-border: rgba(255, 255, 255, 0.1);
            --nav-height: 76px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: #334155;
            padding-top: var(--nav-height); /* Prevent content hiding behind fixed nav */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- GLOBAL ANIMATIONS --- */
        @keyframes fadeInPage {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        main {
            flex: 1; /* Pushes footer down */
            animation: fadeInPage 0.5s ease-out;
        }

        /* --- NAVBAR STYLING --- */
        .logo{
            font-size: 18px;
            width: 35px; 
            height: 35px; 
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); 
            border-radius: 10px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            color: white;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
        }
        .navbar-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            height: var(--nav-height);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: -0.5px;
            font-size: 1.5rem;
            color: #1e293b !important;
        }

        .brand-dot {
            color: var(--primary-color);
        }

        .nav-link {
            font-weight: 500;
            color: #64748b !important;
            transition: color 0.2s;
            margin: 0 5px;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
        }

        /* --- BUTTONS --- */
        .btn-primary-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            border: none;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
            transition: all 0.2s;
        }

        .btn-primary-gradient:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
            color: white;
        }

        .btn-outline-custom {
            border: 2px solid #e2e8f0;
            color: #475569;
            font-weight: 600;
            background: transparent;
        }

        .btn-outline-custom:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: #eef2ff;
        }

        /* --- FOOTER STYLING --- */
        .footer-modern {
            background-color: var(--dark-bg);
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .footer-title {
            color: white;
            font-weight: 700;
            margin-bottom: 1.2rem;
            font-size: 1.1rem;
        }

        .footer-link {
            color: #94a3b8;
            text-decoration: none;
            display: block;
            margin-bottom: 0.8rem;
            transition: color 0.2s;
        }

        .footer-link:hover {
            color: var(--secondary-color);
            padding-left: 5px;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top navbar-glass">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                <div>
                    <i class="bi bi-bag-heart-fill logo"></i>
                </div>
                
                <span style="font-weight: 800; font-size: 1.25rem; letter-spacing: -0.5px; color: #1e293b;">
                    Deal<span style="color: #4f46e5;">Spot</span>
                </span>
            </a>

            <button class="navbar-toggler border-0 p-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a href="/" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="{{ route('explore.deals') }}" class="nav-link">Explore Deals</a></li>
                    <li class="nav-item"><a href="/businesses" class="nav-link">Businesses</a></li>
                    <li class="nav-item"><a href="/contact" class="nav-link">Contact</a></li>
                </ul>

                <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                    @if(session()->has('owner_id'))
                        <a href="{{ route('dashboard') }}" class="btn btn-primary-gradient px-4 rounded-pill">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('owner.login') }}" class="btn btn-outline-custom px-4 rounded-pill">Log In</a>
                        <a href="{{ route('owner.register') }}" class="btn btn-primary-gradient px-4 rounded-pill">
                            For Business
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer-modern pt-5 pb-3 mt-auto border-top rounded-top-4">
        <div class="container">
            <div class="row g-4 mb-5">
                
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-white fw-bold fs-4 mb-3">DealSpot<span class="text-primary">.</span></h5>
                    <p class="mb-4" style="max-width: 300px;">
                        Connecting local businesses with customers through amazing deals and exclusive offers.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white fs-5"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white fs-5"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white fs-5"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3">
                    <h6 class="footer-title">Platform</h6>
                    <a href="/" class="footer-link">Home</a>
                    <a href="/deals" class="footer-link">Browse Deals</a>
                    <a href="/businesses" class="footer-link">Stores</a>
                </div>

                <div class="col-lg-2 col-md-3">
                    <h6 class="footer-title">For Business</h6>
                    <a href="{{ route('owner.login') }}" class="footer-link">Owner Login</a>
                    <a href="{{ route('owner.register') }}" class="footer-link">Register Business</a>
                    <a href="#" class="footer-link">Pricing</a>
                </div>

                <div class="col-lg-4 col-md-12">
                    <h6 class="footer-title">Get in Touch</h6>
                    <div class="d-flex align-items-start mb-3">
                        <i class="bi bi-envelope text-primary mt-1 me-2"></i>
                        <span>support@dealspot.com</span>
                    </div>
                    <div class="d-flex align-items-start">
                        <i class="bi bi-geo-alt text-primary mt-1 me-2"></i>
                        <span>123 Market Street, Suite 400<br>Business City, BC 90210</span>
                    </div>
                </div>
            </div>

            <hr style="border-color: rgba(255,255,255,0.1);">

            <div class="text-center pt-2">
                <p class="mb-0 small opacity-75">
                    &copy; {{ date('Y') }} DealSpot. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>