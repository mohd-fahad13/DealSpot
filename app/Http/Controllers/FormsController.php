<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessOwner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Helpers\MailHelper;

class FormsController extends Controller
{
    // NEW: SHOW LOGIN PAGE
    public function showLogin()
    {
        return view('Forms.login');
    }

    // NEW: SHOW Registration PAGE
    public function showRegistration()
    {
        return view('Forms.register');
    }

    // NEW: SHOW FORGET PASSWORD PAGE
    public function showForgotPassword()
    {
        return view('Forms.forgot-password');
    }

    // public function storeBusinessOwner(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'owner_name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:business_owners,email',
    //         'phone' => 'nullable|string|max:20',
    //         'password' => 'required|min:6|confirmed',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     BusinessOwner::create([
    //         'name' => $request->owner_name,
    //         'email' => $request->email,
    //         'phone' => $request->phone,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     return redirect()->route('owner.login')
    //         ->with('success', 'Registration successful! Please login.');
    // }
    public function storeBusinessOwner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'owner_name' => 'required|string|max:255',
            'email' => 'required|email|unique:business_owners,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
            // 'otp' => 'required|digits:6', // Validate OTP is present
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 🔒 VERIFY OTP SESSION
        $storedOtp = Session::get('reg_otp_' . $request->email);
        // if (!$storedOtp || $storedOtp != $request->otp) {
        //     return redirect()->back()
        //         ->withErrors(['otp' => 'Invalid or expired OTP. Please verify your email again.'])
        //         ->withInput();
        // }

        // Create User
        BusinessOwner::create([
            'name' => $request->owner_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Clear OTP Session
        Session::forget(['reg_otp_' . $request->email]);

        // return redirect()->route('owner.login')
        return redirect()->route('dashboard')
            ->with('success', 'Registration successful! Please login.');
    }
    
    public function checkEmail(Request $request)
    {
        $exists = BusinessOwner::where('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }

    // FIXED: LOGIN FUNCTION
    public function loginOwnerr(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // DEBUG: Check if user exists
        $user = BusinessOwner::where('email', $credentials['email'])->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with this email.'
            ])->withInput();
        }

        // TRY LOGIN WITH CORRECT GUARD
        // if (Auth::guard('business_owner')->attempt($credentials)) {
        //     $request->session()->regenerate();
        //     return redirect()->route('dashboard')
        //         ->with('success', 'Welcome back!');
        // }
        if(Auth::guard('business_owner')->attempt($credentials)) {
            return redirect()->route('dashboard')
                ->with('success', 'Welcome back!');
        }
        
        // return redirect()->route('dashboard')
        //     ->with('success', 'Welcome back!');

        return back()->withErrors([
            'email' => 'not at this time Invalid login credentials.'
        ])->withInput();
    }
    public function loginOwner(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    // Attempt login with business_owner guard
    if (Auth::guard('business_owner')->attempt($credentials)) {
        $request->session()->regenerate();
        
        // Get logged-in user and store ID in session
        $owner = Auth::guard('business_owner')->user();
        session(['owner_id' => $owner->id]);
        
        return redirect()->route('dashboard')
            ->with('success', 'Welcome back ' . $owner->name . '!');
    }

    return back()
        ->withErrors(['email' => 'Invalid email or password.'])
        ->onlyInput('email');
}

    // FOR OTP RESET AND PASSWORD
    // public function sendOtp(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email|exists:business_owners,email', // ✅ FIXED: business_owners
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['success' => false, 'errors' => $validator->errors()]);
    //     }

    //     $email = $request->email;
    //     $otp = rand(100000, 999999);
        
    //     // Store OTP in session
    //     Session::put('reset_otp_' . $email, $otp);
    //     Session::put('reset_email', $email);
        
    //     // 🔥 PERFECT LOGGING
    //     Log::info('🔥 PASSWORD RESET OTP GENERATED', [
    //         'email' => $email,
    //         'otp' => $otp,
    //         'timestamp' => now()->format('Y-m-d H:i:s')
    //     ]);
        
    //     // Send email
    //     try {
    //         Mail::raw("Your OTP is: {$otp}\n\nThis code expires in 10 minutes.", function ($message) use ($email) {
    //             $message->to($email)
    //                     ->subject('Your Password Reset OTP - ' . config('app.name'));
    //         });
            
    //         Log::info('📧 PASSWORD RESET EMAIL SENT', [
    //             'email' => $email,
    //             'otp' => $otp,
    //             'mail_mailer' => config('mail.mailer')
    //         ]);
            
    //     } catch (\Exception $e) {
    //         \Log::error('❌ PASSWORD RESET EMAIL FAILED', [
    //             'email' => $email,
    //             'error' => $e->getMessage()
    //         ]);
    //         return response()->json(['success' => false, 'message' => 'Failed to send email']);
    //     }

    //     return response()->json(['success' => true, 'message' => 'OTP sent successfully']);
    // }
    public function sendOtp(Request $request)
    {
        // 1. Validation Logic
        $type = $request->input('type', 'reset'); // 'reset' or 'register'
        
        $rules = ['email' => 'required|email'];
        if ($type === 'reset') {
            $rules['email'] .= '|exists:business_owners,email'; // Must exist for reset
        } else {
            $rules['email'] .= '|unique:business_owners,email'; // Must NOT exist for register
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        // 2. Generate OTP
        $email = $request->email;
        $otp = rand(100000, 999999);
        
        // 3. Store in Session (Different keys for Register vs Reset to avoid conflicts)
        $prefix = ($type === 'register') ? 'reg_otp_' : 'reset_otp_';
        Session::put($prefix . $email, $otp);
        
        Log::info("🔥 OTP GENERATED ($type)", ['email' => $email, 'otp' => $otp]);
        
        // 4. Send Email using Helper
        $sent = MailHelper::sendOtp($email, $otp);

        if ($sent) {
            return response()->json(['success' => true, 'message' => 'OTP sent successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to send email']);
        }
    }

    // public function verifyOtp(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'otp' => 'required|digits:6',
    //         'email' => 'required|email'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['success' => false, 'errors' => $validator->errors()]);
    //     }

    //     $storedOtp = Session::get('reset_otp_' . $request->email);
        
    //     if ($storedOtp && $storedOtp == $request->otp) {
    //         Session::put('otp_verified_' . $request->email, true);
    //         return response()->json(['success' => true]);
    //     }

    //     return response()->json(['success' => false, 'message' => 'Invalid OTP']);
    // }
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:6',
            'email' => 'required|email',
            'type' => 'nullable|string' // 'register' or 'reset'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        $prefix = ($request->type === 'register') ? 'reg_otp_' : 'reset_otp_';
        $storedOtp = Session::get($prefix . $request->email);
        
        if ($storedOtp && $storedOtp == $request->otp) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid OTP']);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:business_owners,email', // ✅ FIXED
            // 'otp' => 'required|digits:6',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Verify OTP
        $storedOtp = Session::get('reset_otp_' . $request->email);
        if (!$storedOtp || $storedOtp != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP'])->withInput();
        }

        // Update password ✅ FIXED: business_owners table
        DB::table('business_owners')->where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Clear session
        Session::forget(['reset_otp_' . $request->email, 'reset_email', 'otp_verified_' . $request->email]);

        return redirect()->route('owner.login')
                        ->with('success', 'Password reset successfully!');
    }


    
}
