@extends('layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .forgot-container {
        min-height: 100vh;
        overflow-x: hidden;
        margin-top: 0;
    }
    .bg-visual {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    .bg-visual::before,
    .bg-visual::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        z-index: 1;
    }
    .bg-visual::before {
        width: 400px;
        height: 400px;
        top: -100px;
        left: -100px;
        animation: float 8s ease-in-out infinite;
    }
    .bg-visual::after {
        width: 300px;
        height: 300px;
        bottom: 50px;
        right: 50px;
        animation: float 10s ease-in-out infinite reverse;
    }
    .form-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        background-color: #f9fafb;
    }
    .form-card {
        width: 100%;
        max-width: 500px;
        background: white;
        padding: 50px 40px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        animation: slideUp 0.8s ease-out forwards;
    }
    .form-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #10b981, #059669);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .form-subtitle {
        color: #6b7280;
        font-size: 0.95rem;
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    .form-floating > .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding-top: 1.3rem;
        padding-bottom: 0.6rem;
        background-color: #f9fafb;
        transition: all 0.3s ease;
    }
    .form-floating > .form-control:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        background-color: white;
    }
    .form-floating > label {
        color: #6b7280;
        font-weight: 500;
    }
    .btn-gradient {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        color: white;
        padding: 14px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .btn-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.5s ease;
    }
    .btn-gradient:hover::before {
        left: 100%;
    }
    .btn-gradient:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.4);
    }
    .btn-gradient:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    .alert-custom {
        border-radius: 12px;
        border: none;
        padding: 15px 20px;
        font-size: 0.95rem;
        animation: slideDown 0.5s ease-out;
        margin-bottom: 2rem;
    }
    .alert-success-custom {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
        color: #047857;
        border-left: 4px solid #10b981;
    }
    .alert-danger-custom {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }
    .password-strength {
        height: 4px;
        border-radius: 2px;
        margin-top: 8px;
        transition: all 0.3s ease;
        background: #e5e7eb;
    }
    .password-strength.weak {
        background: #ef4444;
        width: 33%;
    }
    .password-strength.medium {
        background: #f59e0b;
        width: 66%;
    }
    .password-strength.strong {
        background: #10b981;
        width: 100%;
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    @media (max-width: 991.98px) {
        .bg-visual { display: none; }
        .form-card { padding: 30px 25px; }
        .form-title { font-size: 1.5rem; }
    }

    /* OTP styles reused */
    .otp-section {
        display: none;
        background: linear-gradient(135deg, rgba(16,185,129,0.08), rgba(5,150,105,0.08));
        border: 2px solid #10b981;
        border-radius: 12px;
        padding: 20px;
        margin: 15px 0;
        animation: slideUp 0.5s ease-out;
    }
    .otp-field {
        font-size: 1.2rem;
        font-weight: 700;
        letter-spacing: 0.1rem;
        text-align: center;
        border: 2px solid #10b981;
    }
    .btn-otp {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        color: white;
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    .btn-otp:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }
    .btn-otp:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    .otp-status {
        min-height: 20px;
        font-size: 0.9rem;
        margin-top: 8px;
    }
    .otp-status.success { color: #10b981; }
    .otp-status.error { color: #dc3545; }
    .otp-timer {
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 4px;
        text-align: center;
    }
</style>

<div class="container-fluid forgot-container p-0">
    <div class="row g-0 h-100">
        <div class="col-lg-7 d-none d-lg-flex bg-visual min-vh-100 border-bottom-0 rounded-bottom-3">
            <div class="text-center px-5">
                <div style="animation: bounce 2s ease-in-out infinite;">
                    <i class="bi bi-shield-check" style="font-size: 5rem; color: rgba(255,255,255,0.9);"></i>
                </div>
                <h2 class="display-5 fw-bold mt-4 mb-3" style="color: white;">Secure Your Account</h2>
                <p class="fs-5" style="opacity: 0.9; line-height: 1.8; color: white;">
                    Verify your email with OTP, then create a strong new password.
                </p>
            </div>
        </div>

        <div class="col-lg-5 col-12 form-wrapper">
            <div class="form-card">
                @if($errors->any())
                    <div class="alert alert-custom alert-danger-custom">
                        <strong><i class="bi bi-exclamation-triangle-fill me-2"></i>Error</strong>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-custom alert-success-custom">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="text-center mb-3">
                    <i class="bi bi-lock" style="font-size: 3.5rem; color: #10b981; animation: float 3s ease-in-out infinite;"></i>
                </div>

                <h2 class="form-title text-center">Reset Password</h2>
                <p class="form-subtitle text-center">
                    Enter your email, verify with OTP, then create a strong new password.
                </p>

                <form action="{{ route('owner.reset-password.submit') }}" method="POST" id="resetForm" novalidate>
                    @csrf

                    <div class="form-floating mb-4">
                        <input type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="emailInput"
                               placeholder="your@email.com"
                               value="{{ old('email') }}"
                               required>
                        <label for="emailInput">Email Address</label>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Get OTP button (same style/location) -->
                    <button type="button" class="btn btn-gradient w-100 mb-2" id="getOtpBtn">
                        <span id="otpBtnText">
                            <i class="bi bi-envelope me-2"></i>Get OTP
                        </span>
                        <span id="otpBtnSpinner" style="display: none;">
                            <i class="bi bi-arrow-repeat animate-spin me-2"></i>Sending...
                        </span>
                    </button>
                    <div class="otp-timer" id="otpTimer"></div>

                    <div class="otp-section" id="otpSection">
                        <div class="text-center mb-3">
                            <i class="bi bi-envelope-check fs-3 text-success"></i>
                            <h6 class="mt-2 mb-0 fw-bold text-success">Check your email</h6>
                            <small class="text-muted">Enter 6-digit code sent to your email</small>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text"
                                   name="otp"
                                   class="form-control otp-field @error('otp') is-invalid @enderror"
                                   id="otpInput"
                                   placeholder="123456"
                                   maxlength="6"
                                   disabled>
                            <label for="otpInput">Enter OTP Code</label>
                            @error('otp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="button" class="btn btn-otp w-100 mb-2" id="btnVerifyOtp" disabled>
                            Verify OTP
                        </button>
                        <div id="otpStatus" class="otp-status text-center"></div>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="passwordInput"
                               placeholder="New Password"
                               disabled
                               required>
                        <label for="passwordInput">New Password</label>
                        <div class="password-strength" id="passwordStrength"></div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-4">
                        <input type="password"
                               name="password_confirmation"
                               class="form-control @error('password_confirmation') is-invalid @enderror"
                               id="confirmInput"
                               placeholder="Confirm Password"
                               disabled
                               required>
                        <label for="confirmInput">Confirm Password</label>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-gradient w-100" id="submitBtn" disabled>
                        <span id="btnText">
                            <i class="bi bi-check2 me-2"></i>Reset Password
                        </span>
                        <span id="btnSpinner" style="display: none;">
                            <i class="bi bi-arrow-repeat animate-spin me-2"></i>Resetting...
                        </span>
                    </button>

                    <a href="{{ route('owner.login') }}" class="d-inline-block mt-3 text-decoration-none" style="color: #10b981; font-weight: 600;">
                        <i class="bi bi-arrow-left me-1"></i> Back to Login
                    </a>
                </form>

                <div style="background: linear-gradient(135deg, rgba(16,185,129,0.08), rgba(5,150,105,0.08)); padding: 1.5rem; border-radius: 12px; margin-top: 2rem; border-left: 4px solid #10b981;">
                    <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">
                        <i class="bi bi-shield-lock me-2" style="color: #10b981;"></i>
                        <strong>Password Tips:</strong> Use at least 6 characters with a mix of letters and numbers.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(function() {
    const $emailInput = $("#emailInput");
    const $getOtpBtn = $("#getOtpBtn");
    const $otpSection = $("#otpSection");
    const $otpInput = $("#otpInput");
    const $btnVerifyOtp = $("#btnVerifyOtp");
    const $passwordInput = $("#passwordInput");
    const $confirmInput = $("#confirmInput");
    const $submitBtn = $("#submitBtn");
    const $passwordStrength = $("#passwordStrength");
    const $otpStatus = $("#otpStatus");
    const $otpTimer = $("#otpTimer");
    const otpCooldownSeconds = 30; // timer duration
    let otpVerified = false;
    let timerId = null;
    let remaining = 0;

    function startOtpTimer() {
        remaining = otpCooldownSeconds;
        updateTimerLabel();
        $getOtpBtn.prop('disabled', true);
        timerId = setInterval(function() {
            remaining--;
            if (remaining <= 0) {
                clearInterval(timerId);
                timerId = null;
                $otpTimer.text('You can request OTP again.');
                if ($emailInput.hasClass('is-valid') && !otpVerified) {
                    $getOtpBtn.prop('disabled', false);
                }
            } else {
                updateTimerLabel();
            }
        }, 1000);
    }

    function updateTimerLabel() {
        $otpTimer.text('Resend OTP in ' + remaining + 's');
    }

    $emailInput.on("input blur", function() {
        const email = $(this).val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email && emailRegex.test(email)) {
            $.ajax({
                url: "{{ route('owner.check.email') }}",
                type: "POST",
                data: { email: email, _token: "{{ csrf_token() }}" },
                success: function (res) {
                    if (!res.exists) {
                        $emailInput.addClass("is-invalid").removeClass("is-valid");
                        $getOtpBtn.prop('disabled', true);
                    } else {
                        $emailInput.removeClass("is-invalid").addClass("is-valid");
                        if (!otpVerified && !timerId) {
                            $getOtpBtn.prop('disabled', false);
                        }
                    }
                },
                error: function() {
                    $emailInput.removeClass("is-valid").addClass("is-invalid");
                    $getOtpBtn.prop('disabled', true);
                }
            });
        } else {
            $emailInput.removeClass("is-valid").addClass("is-invalid");
            $getOtpBtn.prop('disabled', true);
        }
    });

    $getOtpBtn.on("click", function() {
        const email = $emailInput.val().trim();
        const $text = $("#otpBtnText");
        const $spinner = $("#otpBtnSpinner");

        if (!email) return;

        $text.hide();
        $spinner.show();
        $getOtpBtn.prop('disabled', true);

        $.ajax({
            url: "{{ route('owner.send-otp') }}",
            type: "POST",
            data: { email: email, type: 'reset', _token: "{{ csrf_token() }}" },
            success: function(res) {
                if (res.success) {
                    $otpSection.slideDown(400);
                    $otpInput.prop('disabled', false).focus();
                    alert('OTP sent to ' + email + '. Check inbox or logs.');
                    startOtpTimer(); // start cooldown
                } else {
                    alert('Error: ' + res.message);
                    if ($emailInput.hasClass('is-valid')) {
                        $getOtpBtn.prop('disabled', false);
                    }
                }
            },
            error: function() {
                alert('Failed to send OTP. Try again.');
                if ($emailInput.hasClass('is-valid')) {
                    $getOtpBtn.prop('disabled', false);
                }
            },
            complete: function() {
                $text.show();
                $spinner.hide();
                $getOtpBtn.text('Resend OTP');
            }
        });
    });

    $otpInput.on("input", function() {
        $(this).removeClass("is-invalid is-valid");
        if ($(this).val().length === 6) {
            $btnVerifyOtp.prop('disabled', false);
        } else {
            $btnVerifyOtp.prop('disabled', true);
        }
    });

    $btnVerifyOtp.on("click", function() {
        const otp = $otpInput.val().trim();
        const email = $emailInput.val().trim();
        const $btn = $(this);

        if (otp.length !== 6) {
            $otpStatus.html('<span class="text-danger">Enter 6-digit code</span>').addClass('error');
            return;
        }

        $btn.html('<i class="bi bi-arrow-repeat animate-spin"></i> Verifying...').prop('disabled', true);

        $.ajax({
            url: "{{ route('owner.verify-otp') }}",
            type: "POST",
            data: { email: email, otp: otp, type: 'reset', _token: "{{ csrf_token() }}" },
            success: function(res) {
                if (res.success) {
                    otpVerified = true;
                    $otpStatus.html('<i class="bi bi-check-circle-fill me-2"></i> Email verified successfully!').removeClass('error').addClass('success text-success');
                    $otpInput.prop('disabled', true);
                    $btn.hide();
                    $emailInput.prop('readonly', true);
                    $getOtpBtn.prop('disabled', true);
                    if (timerId) {
                        clearInterval(timerId);
                        timerId = null;
                    }
                    $otpTimer.text('');
                    $passwordInput.prop('disabled', false);
                    $confirmInput.prop('disabled', false);
                    $submitBtn.prop('disabled', false);
                    $otpSection.addClass('border-success');
                } else {
                    $otpStatus.html('<i class="bi bi-x-circle-fill me-2"></i>' + (res.message || 'Invalid OTP')).addClass('error text-danger');
                    $otpInput.addClass('is-invalid');
                    $btn.html('Verify OTP').prop('disabled', false);
                }
            },
            error: function() {
                $otpStatus.html('<i class="bi bi-exclamation-triangle-fill me-2"></i>Verification failed').addClass('error text-danger');
                $btn.html('Verify OTP').prop('disabled', false);
            }
        });
    });

    $passwordInput.on("input", function() {
        const password = $(this).val();
        $passwordStrength.removeClass('weak medium strong');
        if (password.length >= 6) {
            if (password.length < 10) $passwordStrength.addClass('weak');
            else if (password.length < 14) $passwordStrength.addClass('medium');
            else $passwordStrength.addClass('strong');
        }
        if ($confirmInput.val()) validatePasswordMatch();
    });

    $confirmInput.on("input", validatePasswordMatch);

    function validatePasswordMatch() {
        const password = $passwordInput.val();
        const confirm = $confirmInput.val();
        $confirmInput.removeClass("is-invalid is-valid");
        if (confirm && password !== confirm) {
            $confirmInput.addClass("is-invalid");
        } else if (confirm && password === confirm) {
            $confirmInput.addClass("is-valid");
        }
        checkReady();
    }

    function checkReady() {
        const passOk = $passwordInput.val().length >= 6;
        const match = $passwordInput.val() === $confirmInput.val();
        $submitBtn.prop('disabled', !(otpVerified && passOk && match));
    }

    $("#resetForm").on("submit", function(e) {
        if (!otpVerified) {
            e.preventDefault();
            alert('Please verify OTP first.');
        } else {
            $submitBtn.prop('disabled', true);
            $("#btnText").hide();
            $("#btnSpinner").show();
        }
    });

    $(".form-control").on("focus", function() {
        $(this).removeClass("is-invalid");
    });
});
</script>

@endsection
