<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\{
    User
};

class AuthController extends Controller
{
    public function view(Request $request)
    {
        $button_message = "Send OTP";
        $user = null;
        if ($request->session()->has('otp_send')) {
            $user = User::findOrFail($request->session()->get('otp_send'));
            $button_message = $user->is_registered ? "Submit" : "Verify OTP";
        }
        return view('student.auth.register', compact(
            'user',
            'button_message'
        ));    
    }

    public function store(Request $request)
    {
        if ($request->filled('phone')) {
            $otp = rand(111111, 999999);
            $user = User::where('phone', $request->phone)->first();
            if (is_null($user)) {
                $user = new User;
                $user->phone = $request->phone;
            }
            $user->otp = $otp;
            $user->save();

            $request->session()->put('otp_send', $user->id);

            return response()->json([
                'success' => false,
                'elements' => [
                    'hide_element' => 'phone-container',
                    'show_element' => 'otp-container'
                ],
                'button_message' => "Verify OTP"
            ]);
        }

        if ($request->filled('otp') && $request->session()->has('otp_send')) {
            $user = User::find($request->session()->get('otp_send'));
            if ($user->otp == $request->otp) {
                $user->is_registered = 1;
                $user->otp = null;
                $user->save();
                return response()->json([
                    'success' => false,
                    'elements' => [
                        'hide_element' => 'otp-container',
                        'show_element' => 'basic-info-container'
                    ],
                    'button_message' => "Submit"
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'elements' => [
                        'hide_element' => 'phone-container',
                        'show_element' => 'otp-container'
                    ],
                    'button_message' => "Verify OTP"
                ]);
            }
        }

        if ($request->filled('name') && $request->filled('password')) {
            $user = User::findOrFail($request->session()->get('otp_send'));
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            Auth::login($user);

            return response()->json([
                'success' => true,
                'redirect_url' => route('student.dashboard')
            ]);
        }
    }

    public function checkField(Request $request)
    {
        if ($request->filled('phone')) {
            return response()->json(
                !User::where('phone', $request->phone)
                        ->where('is_registered', 1)
                        ->exists()
            );
        } elseif($request->filled('email')) {
            return response()->json(
                !User::where('email', $request->email)->exists()
            );
        }
    }
}
