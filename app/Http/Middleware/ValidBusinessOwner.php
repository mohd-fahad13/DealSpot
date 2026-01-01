<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class ValidBusinessOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        echo "<h3>We are now in valid Middleware</h3>";
        // if(Auth::check()){
        //     echo "<h3>Auth check in valid Middleware</h3>";
        //     return $next($request);
        // } else {
        //     return redirect()->route('owner.login');
        // }

        if(Auth::guard('business_owner')->check()){  // Use correct guard
            return $next($request);
        } 
        
        return redirect()->route('owner.login');
    }
}
