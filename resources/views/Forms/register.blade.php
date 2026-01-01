@extends('layouts.app')

@section('content')

{{-- Extra icon support --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* ✅ NO TOP MARGIN */
    .register-container {
        min-height: 100vh;
        overflow-x: hidden;
        margin-top: 0;
        padding-top: 0;
    }

    /* 🔥 INFINITE ANIMATION BACKGROUND */
    .bg-visual {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
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
    /* Infinite Float Animation */
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
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        animation: slideUp 0.8s ease-out forwards;
    }
    .form-floating > .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding-top: 1.3rem;
        padding-bottom: 0.6rem;
    }
    .form-floating > .form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
    }
    .form-floating > label {
        color: #6b7280;
    }
    .form-control.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
    }
    .form-control.is-valid {
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
    }
    .btn-gradient {
        background: linear-gradient(to right, #4f46e5, #7c3aed);
        border: none;
        color: white;
        padding: 14px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
        overflow: hidden;
    }
    .btn-gradient:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.35);
    }
    .btn-gradient:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    .brand-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        position: relative;
        z-index: 2;
    }
    .brand-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        position: relative;
        z-index: 2;
    }

    /* ANIMATIONS */
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
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
        display: inline-block;
        font-size: 0.875em;
    }
    .animate-text {
        animation: fadeIn 1.2s ease-in forwards;
    }

    /* OTP STYLES */
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
    .otp-status {
        min-height: 20px;
        font-size: 0.9rem;
        margin-top: 8px;
    }
    .otp-status.success { color: #10b981; }
    .otp-status.error { color: #dc3545; }
    
    /* TIMER STYLE */
    .otp-timer {
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 5px;
        text-align: right;
        min-height: 1.2em;
    }

    /* INPUT GROUP FOR SEPARATE BUTTON */
    .input-group .form-floating {
        flex-grow: 1;
    }
    .input-group .form-floating .form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-right: 0;
    }
    .btn-get-otp-separate {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        background: #1f2937; /* Dark button */
        color: white;
        border: 2px solid #1f2937;
        padding: 0 20px;
        font-weight: 600;
        transition: all 0.3s;
        z-index: 5;
    }
    .btn-get-otp-separate:hover:not(:disabled) {
        background: #111827;
        border-color: #111827;
    }
    .btn-get-otp-separate:disabled {
        background: #9ca3af;
        border-color: #9ca3af;
        cursor: not-allowed;
    }
</style>

<div class="container-fluid register-container p-0">
    <div class="row g-0 h-100">
        <!-- LEFT VISUAL SECTION -->
        <div class="col-lg-7 d-none d-lg-flex bg-visual min-vh-100">
            <div class="text-center px-5 animate-text">
                <h1 class="brand-title">Your Business Journey Starts Here.</h1>
                <p class="brand-subtitle">Smart tools, simple setup, powerful growth — join thousands already scaling with ease.</p>
                <div class="mt-5" 
                     style="border: 2px dashed rgba(255,255,255,0.3); width: 100px; height: 100px; border-radius: 50%; display: inline-block; animation: spin 10s linear infinite;">
                </div>
            </div>
        </div>

        <!-- RIGHT FORM SECTION -->
        <div class="col-lg-5 col-12 form-wrapper">
            <div class="form-card">
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success rounded-3 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4 text-center">
                    <h3 class="fw-bold text-dark">Create Your Account</h3>
                    <p class="text-muted small">Register as a Business Owner to get started</p>
                </div>

                <form action="{{ route('owner.register.submit') }}" method="POST" id="registrationForm" novalidate>
                    @csrf

                    <!-- OWNER NAME -->
                    <div class="form-floating mb-3">
                        <input type="text" 
                               name="owner_name" 
                               class="form-control @error('owner_name') is-invalid @enderror" 
                               id="ownerName" 
                               placeholder="John" 
                               value="{{ old('owner_name') }}"
                               required>
                        <label for="ownerName">Owner Full Name</label>
                        @error('owner_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- EMAIL + SEPARATE BUTTON -->
                    <div class="input-group mb-0">
                        <div class="form-floating">
                            <input type="email" 
                                   name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="emailAddr" 
                                   placeholder="name@example.com" 
                                   value="{{ old('email') }}"
                                   required>
                            <label for="emailAddr">Email Address</label>
                        </div>
                        <button type="button" class="btn btn-get-otp-separate" id="btnGetOtp" disabled>
                            <span id="otpBtnText">Get OTP</span>
                            <i id="otpBtnSpinner" class="bi bi-arrow-repeat animate-spin" style="display: none;"></i>
                        </button>
                    </div>
                    <!-- Timer Display -->
                    <div class="otp-timer" id="otpTimer"></div>
                    
                    <div id="emailStatus" class="form-text mb-3" style="margin-top: 0px;"></div>
                    @error('email')
                        <div class="text-danger small mb-3">{{ $message }}</div>
                    @enderror

                    <!-- OTP VERIFICATION SECTION -->
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

                    <!-- PHONE -->
                    <div class="form-floating mb-3">
                        <input type="text" 
                               name="phone" 
                               class="form-control @error('phone') is-invalid @enderror" 
                               id="phoneNum" 
                               placeholder="9876543210" 
                               value="{{ old('phone') }}"
                               required>
                        <label for="phoneNum">Phone Number</label>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- PASSWORD FIELDS -->
                    <div class="row g-2 mb-4">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="password" 
                                       name="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="passInput" 
                                       placeholder="Password" 
                                       required>
                                <label for="passInput">Password</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="password" 
                                       name="password_confirmation" 
                                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       id="passConf" 
                                       placeholder="Confirm Password" 
                                       required>
                                <label for="passConf">Confirm Password</label>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <button type="submit" class="btn btn-gradient w-100" id="btnRegister" disabled>
                        <i class="bi bi-check2-circle me-2"></i>Create Account
                    </button>

                    <!-- LOGIN LINK -->
                    <div class="text-center mt-4">
                        <span class="text-muted">Already registered?</span>
                        <a href="{{ route('owner.login') }}" class="fw-bold text-decoration-none" style="color:#4f46e5;">
                            LogIn
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function () {
    let otpVerified = false;
    let emailValid = false;
    let timerId = null;
    let remaining = 0;
    const otpCooldownSeconds = 30; // ⏳ 30 Second Timer

    // Cache fields
    const $ownerNameField = $("#ownerName");
    const $emailField = $("#emailAddr");
    const $phoneField = $("#phoneNum");
    const $passField = $("#passInput");
    const $confirmPassField = $("#passConf");
    const $form = $("#registrationForm");
    const $otpTimer = $("#otpTimer");

    /* TIMER FUNCTIONS */
    function startOtpTimer() {
        remaining = otpCooldownSeconds;
        updateTimerLabel();
        $("#btnGetOtp").prop('disabled', true);
        
        timerId = setInterval(function() {
            remaining--;
            if (remaining <= 0) {
                clearInterval(timerId);
                timerId = null;
                $otpTimer.text('You can request OTP again.');
                if (emailValid && !otpVerified) {
                    $("#btnGetOtp").prop('disabled', false).text('Resend OTP');
                }
            } else {
                updateTimerLabel();
            }
        }, 1000);
    }

    function updateTimerLabel() {
        $otpTimer.text('Resend OTP in ' + remaining + 's');
    }

    /* EMAIL VALIDATION + AVAILABILITY CHECK */
    $emailField.on("input blur", function () {
        const email = $(this).val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && emailRegex.test(email)) {
            $.ajax({
                url: "{{ route('owner.check.email') }}",
                type: "POST",
                data: { email: email, _token: "{{ csrf_token() }}" },
                success: function (res) {
                    if (res.exists) {
                        $emailField.addClass("is-invalid").removeClass("is-valid");
                        $("#emailStatus").html('<span class="text-danger">Email already registered</span>');
                        $("#btnGetOtp").prop('disabled', true);
                        emailValid = false;
                    } else {
                        $emailField.removeClass("is-invalid").addClass("is-valid");
                        $("#emailStatus").html('<span class="text-success">Available ✓</span>');
                        
                        // Only enable button if no timer is running
                        if (!otpVerified && !timerId) {
                            $("#btnGetOtp").prop('disabled', false);
                        }
                        emailValid = true;
                    }
                },
                error: function() {
                    $("#emailStatus").html('<span class="text-warning">Check failed</span>');
                }
            });
        } else {
            $emailField.removeClass("is-valid").addClass("is-invalid");
            $("#emailStatus").empty();
            $("#btnGetOtp").prop('disabled', true);
            emailValid = false;
        }
    });

    /* GET OTP BUTTON */
    $("#btnGetOtp").on("click", function() {
        const email = $emailField.val().trim();
        const $btn = $(this);
        const $text = $("#otpBtnText");
        const $spinner = $("#otpBtnSpinner");

        $text.hide();
        $spinner.show();
        $btn.prop('disabled', true);

        $.ajax({
            url: "{{ route('owner.send-otp') }}",
            type: "POST",
            data: { email: email, type: 'register', _token: "{{ csrf_token() }}" },
            success: function(res) {
                if (res.success) {
                    $("#otpSection").slideDown(400);
                    $("#otpInput").prop('disabled', false).focus();
                    alert(`✅ OTP sent to ${email}! Check inbox.`);
                    startOtpTimer(); // 🔥 Start Timer
                } else {
                    alert(`❌ ${res.message}`);
                    if (emailValid) $btn.prop('disabled', false); // Enable if failed
                }
            },
            error: function(xhr) {
                alert('Failed to send OTP.');
                if (emailValid) $btn.prop('disabled', false);
            },
            complete: function() {
                $text.show();
                $spinner.hide();
            }
        });
    });

    /* OTP INPUT + VERIFY */
    $("#otpInput").on("input", function() {
        $(this).removeClass("is-invalid is-valid");
        if ($(this).val().length === 6) {
            $("#btnVerifyOtp").prop('disabled', false);
        } else {
            $("#btnVerifyOtp").prop('disabled', true);
        }
    });

    $("#btnVerifyOtp").on("click", function() {
        const otp = $("#otpInput").val().trim();
        const email = $emailField.val().trim();
        const $btn = $(this);
        const $status = $("#otpStatus");

        if (otp.length !== 6) {
            $status.html('<span class="text-danger">Enter 6-digit code</span>');
            return;
        }

        $btn.html('<i class="bi bi-arrow-repeat animate-spin"></i> Verifying...').prop('disabled', true);

        $.ajax({
            url: "{{ route('owner.verify-otp') }}",
            type: "POST",
            data: { email: email, otp: otp, type: 'register', _token: "{{ csrf_token() }}" },
            success: function(res) {
                if (res.success) {
                    otpVerified = true;
                    $status.html('<i class="bi bi-check-circle-fill me-2"></i> Email verified successfully!').addClass('text-success').removeClass('text-danger');
                    $("#otpInput, #btnVerifyOtp, #btnGetOtp").prop('disabled', true);
                    $("#btnRegister").prop('disabled', false);
                    $("#otpSection").addClass('border-success');
                    
                    // Stop timer
                    if(timerId) clearInterval(timerId);
                    $otpTimer.text('');
                    
                } else {
                    $status.html('<i class="bi bi-x-circle-fill me-2"></i>' + (res.message || 'Invalid OTP')).addClass('text-danger');
                    $("#otpInput").addClass('is-invalid');
                    $btn.html('Verify OTP').prop('disabled', false);
                }
            },
            error: function() {
                $status.html('<i class="bi bi-exclamation-triangle-fill me-2"></i>Verification failed').addClass('text-danger');
                $btn.html('Verify OTP').prop('disabled', false);
            }
        });
    });

    /* ORIGINAL VALIDATIONS (Name, Phone, Password) */
    $ownerNameField.on("input blur", function () {
        const value = $(this).val().trim();
        const nameRegex = /^[A-Za-z\s]{3,}$/;
        const isValid = value !== "" && nameRegex.test(value);
        $(this).toggleClass("is-invalid", !isValid && value !== "");
        $(this).toggleClass("is-valid", isValid);
    });

    $phoneField.on("input", function () {
        let value = $(this).val().replace(/\D/g, '');
        $(this).val(value);
        const phoneRegex = /^[0-9]{10}$/;
        const isValid = phoneRegex.test(value);
        $(this).toggleClass("is-invalid", !isValid && value !== "");
        $(this).toggleClass("is-valid", isValid);
    });

    $passField.on("input", function () {
        const value = $(this).val();
        const isValid = value.length >= 6;
        $(this).toggleClass("is-invalid", !isValid && value !== "");
        $(this).toggleClass("is-valid", isValid);
    });

    $confirmPassField.on("input", function () {
        const passValue = $passField.val();
        const confirmValue = $(this).val();
        const isMatch = confirmValue === passValue && passValue.length >= 6;
        $(this).toggleClass("is-invalid", !isMatch && confirmValue !== "");
        $(this).toggleClass("is-valid", isMatch);
    });

    /* FORM SUBMIT */
    $form.on("submit", function (e) {
        if (!otpVerified) {
            e.preventDefault();
            alert("⚠️ Please verify your email with OTP first!");
            $("#otpSection").slideDown();
            $("#otpInput").focus();
            return false;
        }
    });

    $(".form-control").on("focus", function() {
        $(this).removeClass("is-invalid");
        $(this).closest('.form-floating').find('.invalid-feedback').hide();
    });
});
</script>

@endsection
