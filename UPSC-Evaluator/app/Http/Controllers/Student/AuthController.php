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
                $request->session()->put('otp_verified', $user->id);
                $request->session()->forget('otp_send');
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
                    'button_message' => "Verify OTP",
                    'otp_invalid' => true
                ]);
            }
        }

        if ($request->filled('name') && $request->filled('password') && $request->session()->has('otp_verified')) {
            $user = User::findOrFail($request->session()->get('otp_verified'));
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            $request->session()->forget('otp_verified');
            Auth::login($user);

            return response()->json([
                'success' => true,
                'redirect_url' => route('student.dashboard')
            ]);
        }
    }

    public function forgotPassword(Request $request)
    {
        if ($request->filled('phone')) {
            $user = User::where('phone', $request->phone)->first();
            if (!is_null($user)) {
                if (!$user->is_registered) {
                    return response()->json([
                        'success' => false,
                        'elements' => [
                            'hide_element' => 'otp-container',
                            'show_element' => 'phone-container'
                        ],
                        'button_message' => "Send OTP",
                        'error_message' => "This phone number is not exist in our system."
                    ]);
                }

                $user->otp = rand(111111, 999999);
                $user->save();
                $request->session()->put('otp_send', $user->id);

                return response()->json([
                    'success' => false,
                    'elements' => [
                        'hide_element' => 'phone-container',
                        'show_element' => 'otp-container'
                    ],
                    'button_message' => "Verify OTP",
                    'success_message' => "OTP send successfully on your phone."
                ]);
            }
            return response()->json([
                'success' => false,
                'elements' => [
                    'hide_element' => 'otp-container',
                    'show_element' => 'phone-container'
                ],
                'button_message' => "Send OTP",
                'error_message' => "This phone number is not exist in our system."
            ]);

        }

        if ($request->filled('otp') && $request->session()->has('otp_send')) {
            $user = User::find($request->session()->get('otp_send'));
            if ($user->otp == $request->otp) {

                $request->session()->put('otp_verified', $user->id);
                $request->session()->forget('otp_send');

                return response()->json([
                    'success' => false,
                    'elements' => [
                        'hide_element' => 'otp-container',
                        'show_element' => 'forgot-passowrd-container'
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
                    'button_message' => "Verify OTP",
                    'error_message' => "Invalid OTP"
                ]);
            }
        }

        if ($request->filled('password') && $request->session()->has('otp_verified')) {
            $user = User::find($request->session()->get('otp_verified'));
            $user->password = Hash::make($request->password);
            $user->save();
            $request->session()->forget('otp_verified');
            return response()->json([
                'success' => true,
                'redirect_url' => route('student.login')
            ]);
        }
    }

    public function passwordLogin(Request $request)
    {
        $field_type = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $credentials = array(
            $field_type => $request->username,
            'password' => $request->password
        );
        if (Auth::attempt($credentials, 1)) {
            return redirect()->route('student.dashboard');
        }
        return back()
                ->withErrors(['error' => 'The provided credentials do not match our records.'])
                ->withInput($request->except('password'))
                ->with([
                    'password' => $request->password,
                    'username' => $request->username,
                ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function otpResend(Request $request)
    {
        $user = User::find($request->session()->get('otp_send'));
        if (!is_null($user)) {
            if (!$user->is_registered && !$request->has('register_event')) {
                return response()->json([
                    'success' => false,
                    'elements' => [
                        'hide_element' => 'phone-container',
                        'show_element' => 'otp-container'
                    ],
                    'button_message' => "Send OTP",
                    'error_message' => "This phone number is not exist in our system."
                ]);
            }

            $user->otp = rand(111111, 999999);
            $user->save();

            return response()->json([
                'success' => false,
                'elements' => [
                    'hide_element' => 'phone-container',
                    'show_element' => 'otp-container'
                ],
                'button_message' => "Verify OTP",
                'success_message' => "OTP Resend successfully on your phone."
            ]);
        }
        return response()->json([
            'success' => false,
            'elements' => [
                'hide_element' => 'phone-container',
                'show_element' => 'otp-container'
            ],
            'button_message' => "Send OTP",
            'error_message' => "This phone number is not exist in our system."
        ]);
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
