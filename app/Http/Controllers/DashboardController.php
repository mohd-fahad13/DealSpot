<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function showDashboard()
    {
        return view('dashboard');
    }
    
    // NEW: LOGOUT
    public function logout(Request $request)
    {
        Auth::guard('business_owner')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('owner.login');
    }
}
