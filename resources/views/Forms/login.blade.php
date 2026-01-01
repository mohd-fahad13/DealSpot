@extends('layouts.app')

@section('content')

<style>
    /* --- YOUR ORIGINAL STYLES (UNCHANGED) --- */
    body {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .login-wrapper {
        min-height: 100vh;
        width: 100%;
        background-color: #ffffff;
        overflow: hidden;
    }

    /* --- LEFT SIDE (Second Code Styling) --- */
    .form-side {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 4rem;
        background: #ffffff;
        position: relative;
        z-index: 10;
    }

    .form-content {
        max-width: 420px;
        width: 100%;
        margin: 0 auto;
        animation: slideInLeft 0.8s ease-out forwards;
    }

    /* Inputs */
    .custom-input-group {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .form-control-custom {
        width: 100%;
        padding: 16px 20px;
        font-size: 1rem;
        background-color: #f3f4f6;
        border: 2px solid transparent;
        border-radius: 12px;
        transition: all 0.3s ease;
        color: #1f2937;
    }

    .form-control-custom:focus {
        background-color: #ffffff;
        border-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(59,130,246,0.15);
        outline: none;
    }

    /* NEW: VALIDATION STATES (Minimal addition) */
    .form-control-custom.is-invalid {
        border-color: #dc3545 !important;
        background-color: #fef2f2;
        box-shadow: 0 4px 12px rgba(220,53,69,0.15);
    }

    .form-control-custom.is-valid {
        border-color: #198754 !important;
        background-color: #f0fdf4;
        box-shadow: 0 4px 12px rgba(25,135,84,0.15);
    }

    .input-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: block;
    }

    /* NEW: ERROR MESSAGES (Minimal) */
    .error-message {
        font-size: 0.8rem;
        color: #dc3545;
        margin-top: 6px;
        display: none;
        font-weight: 500;
    }

    .error-message.show {
        display: block !important;
    }

    /* Submit Button */
    .btn-hero {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        transition: 0.3s ease;
        cursor: pointer;
    }

    .btn-hero:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        color: white;
    }

    .btn-hero:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* --- RIGHT SIDE (YOUR ORIGINAL STYLES - UNCHANGED) --- */
    .visual-section {
        background: linear-gradient(135deg, #1e1b4b 0%, #4338ca 100%);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        padding: 3rem;
    }

    .visual-section::before {
        content: '';
        position: absolute;
        top: -10%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .visual-section::after {
        content: '';
        position: absolute;
        bottom: 10%;
        left: 10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .visual-content {
        text-align: center;
        position: relative;
        z-index: 3;
        animation: fadeInScale 1s ease-out forwards;
        max-width: 80%;
    }

    .glass-box {
        background: rgba(255,255,255,0.1);
        padding: 20px;
        border-radius: 20px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        display: inline-block;
        margin-top: 40px;
    }

    /* Animations */
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes fadeInScale {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    /* Responsive */
    @media (max-width: 991.98px) {
        .visual-section {
            display: none;
        }
        .form-side {
            padding: 2rem;
        }
    }
</style>

{{-- JQUERY CDN --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<div class="container-fluid p-0">
    <div class="row g-0 login-wrapper">

        {{-- LEFT SIDE (YOUR ORIGINAL + VALIDATION) --}}
        <div class="col-lg-6 form-side">
            <div class="form-content">

                {{-- SHOW ERRORS --}}
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4 p-3">
                        @foreach ($errors->all() as $error)
                            <div><i class="fas fa-exclamation-triangle me-2"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success rounded-3 mb-4 p-3">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-5">
                    <div class="d-flex align-items-center mb-2">
                        <span class="bg-primary rounded-circle d-inline-block me-2" style="width: 12px; height: 12px;"></span>
                        <span class="fw-bold text-uppercase text-primary small">Business Portal</span>
                    </div>
                    <h1 class="fw-bolder display-6 text-dark mb-2">Welcome Back.</h1>
                    <p class="text-muted">Log in to manage your inventory, sales, and staff.</p>
                </div>

                <form action="{{ route('owner.login.submit') }}" method="POST" id="loginForm" novalidate>
                    @csrf

                    <div class="custom-input-group">
                        <label class="input-label">Email Address</label>
                        <input type="email" 
                               name="email" 
                               id="loginEmail" 
                               class="form-control-custom" 
                               placeholder="name@business.com" 
                               value="{{ old('email') }}"
                               required>
                        <div class="error-message" id="emailError">Please enter a valid email address</div>
                    </div>

                    <div class="custom-input-group">
                        <div class="d-flex justify-content-between">
                            <label class="input-label">Password</label>
                            <a href="{{ route('owner.reset-password') }}" class="small fw-semibold text-primary">Forgot?</a>
                        </div>
                        <input type="password" 
                               name="password" 
                               id="loginPassword" 
                               class="form-control-custom" 
                               placeholder="••••••••" 
                               required>
                        <div class="error-message" id="passwordError">Password must be at least 6 characters</div>
                    </div>

                    <button type="submit" class="btn-hero mt-4" id="loginBtn">
                        <span id="btnText">Sign In to Dashboard</span>
                        <span id="btnSpinner" style="display:none;">
                            <i class="fas fa-spinner fa-spin me-2"></i>Signing In...
                        </span>
                    </button>

                    <div class="text-center mt-4">
                        <p class="text-muted small">
                            Don't have a business account?
                            <a href="{{ route('owner.register') }}" class="fw-bold text-dark text-decoration-none border-bottom border-dark pb-1">Register Now</a>
                        </p>
                    </div>
                </form>

            </div>
        </div>

        {{-- RIGHT SIDE (YOUR ORIGINAL - UNCHANGED) --}}
        <div class="col-lg-6 d-none d-lg-flex visual-section border-bottom-0 rounded-bottom-3">
            <div class="visual-content">
                <h2 class="display-5 fw-bold mb-4">Scale your business with confidence.</h2>
                <p class="lead text-white-50 mb-5">
                    Join over 10,000 shop owners who trust our platform to handle their daily operations securely.
                </p>
                <div class="glass-box">
                    <div class="d-flex gap-3 align-items-center opacity-75 mb-3">
                        <div class="rounded-circle bg-success" style="width:12px; height:12px;"></div>
                        <div class="rounded-circle bg-warning" style="width:12px; height:12px;"></div>
                        <div class="rounded-circle bg-danger" style="width:12px; height:12px;"></div>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-3" style="height: 8px; width: 180px;"></div>
                    <div class="mt-2 bg-white bg-opacity-10 rounded-3" style="height: 8px; width: 120px;"></div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- JQUERY VALIDATION --}}
<script>
$(document).ready(function() {
    const $emailField = $("#loginEmail");
    const $passwordField = $("#loginPassword");
    const $form = $("#loginForm");
    const $loginBtn = $("#loginBtn");
    const $emailError = $("#emailError");
    const $passwordError = $("#passwordError");

    /* EMAIL VALIDATION */
    $emailField.on("blur input", function() {
        const email = $(this).val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        $(this).removeClass("is-invalid is-valid");
        $emailError.removeClass("show");
        
        if (email.length > 0 && !emailRegex.test(email)) {
            $(this).addClass("is-invalid");
            $emailError.addClass("show");
        } else if (email.length > 0) {
            $(this).addClass("is-valid");
        }
    });

    /* PASSWORD VALIDATION */
    $passwordField.on("input", function() {
        const password = $(this).val();
        $(this).removeClass("is-invalid is-valid");
        $passwordError.removeClass("show");
        
        if (password.length > 0 && password.length < 6) {
            $(this).addClass("is-invalid");
            $passwordError.addClass("show");
        } else if (password.length >= 6) {
            $(this).addClass("is-valid");
        }
    });

    /* FORM SUBMIT VALIDATION */
    $form.on("submit", function(e) {
        let isValid = true;
        
        // Clear previous states
        $emailField.removeClass("is-invalid is-valid");
        $passwordField.removeClass("is-invalid is-valid");
        $emailError.removeClass("show");
        $passwordError.removeClass("show");

        // Validate email
        const email = $emailField.val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email || !emailRegex.test(email)) {
            $emailField.addClass("is-invalid");
            $emailError.addClass("show");
            isValid = false;
        }

        // Validate password
        const password = $passwordField.val();
        if (!password || password.length < 6) {
            $passwordField.addClass("is-invalid");
            $passwordError.addClass("show");
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            $emailField.focus();
            return false;
        }

        // Show loading
        $loginBtn.prop("disabled", true);
        $("#btnText").hide();
        $("#btnSpinner").show();
    });

    /* CLEAR ERRORS ON FOCUS */
    $(".form-control-custom").on("focus", function() {
        $(this).removeClass("is-invalid");
        $(this).closest(".custom-input-group").find(".error-message").removeClass("show");
    });
});
</script>

@endsection
