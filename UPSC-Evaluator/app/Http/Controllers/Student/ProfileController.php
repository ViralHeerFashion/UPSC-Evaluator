<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\{
    User
};

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Profile Updated successfully...');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        if (!is_null($user->plain_password)) {
            $user->plain_password = null;
            $user->save();

            return redirect()->route('student.logout');
        }
        return back()->with('success', 'Password Updated successfully...');
    }

    public function checkEmail(Request $request)
    {
        return response()->json(
            !User::where('id', '!=', Auth::id())
                        ->where('email', $request->email)
                        ->exists()
        );
    }
}
