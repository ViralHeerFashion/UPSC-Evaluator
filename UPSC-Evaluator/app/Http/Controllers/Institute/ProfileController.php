<?php

namespace App\Http\Controllers\Institute;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('institute.profile.index');    
    }

    public function update(Request $request)
    {
        $institute = Auth::guard('institute')->user();
        $institute->password = Hash::make($request->password);
        $institute->save();

        return back()->with('alert_success', 'Password updated successfully...');
    }
}
