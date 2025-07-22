<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

    	if (Auth::guard('admin')->attempt($credentials, 1)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
		}
    }
}
