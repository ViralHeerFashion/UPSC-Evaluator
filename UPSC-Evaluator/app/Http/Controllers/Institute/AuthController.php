<?php

namespace App\Http\Controllers\Institute;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

    	if (Auth::guard('institute')->attempt($credentials, 1)) {
            $request->session()->regenerate();

            return redirect()->route('institute.students');
		}

        return back();
    }
}
