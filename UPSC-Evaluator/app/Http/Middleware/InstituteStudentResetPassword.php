<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class InstituteStudentResetPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::user()->status) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()
                    ->route('student.login')
                    ->withErrors(['error' => "Sorry! Your Account was deactive. please contact our support team"]);
        }
        if (!is_null(Auth::user()->plain_password) && !in_array(Route::currentRouteName(), ['student.profile.security', 'student.profile.update-password', 'student.logout'])) {
            return redirect()->route('student.profile.security')->with('alert_success', "Please reset password.");
        }
        return $next($request);
    }
}
