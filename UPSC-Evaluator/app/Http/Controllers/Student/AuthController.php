<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\Affiliate\{
    StudentRegistrationMail
};
use App\Models\{
    User,
    Institute,
    Affiliate,
    Recharge,
    Wallet
};

class AuthController extends Controller
{
    public function __construct(Request $request)
    {
        if ($request->filled('institute')) {
            $institute = Institute::select('logo')
                                        ->where('uuid', $request->institute)
                                        ->first();
            Cookie::queue('institute', json_encode($institute), 525600);
        }
    }

    public function login(Request $request)
    {
        if ($request->filled('institute')) {
            $institute = Institute::select('logo')
                ->where('uuid', $request->institute)
                ->first();
        } elseif ($request->hasCookie('institute')) {
            $institute = json_decode($request->cookie('institute'));
        } else {
            $institute = null;
        }
        return view('student.auth.login', compact(
            'institute'
        ));
    }

    public function view(Request $request)
    {
        $button_message = "Send OTP";
        $user = null;
        $institute = null;
        if($request->hasCookie('institute')) {
            $institute = json_decode($request->cookie('institute'));
        }
        if ($request->session()->has('otp_send')) {
            $user = User::findOrFail($request->session()->get('otp_send'));
            $button_message = $user->is_registered ? "Submit" : "Verify OTP";
        }
        return view('student.auth.register', compact(
            'user',
            'button_message',
            'institute'
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

            $request_id = $this->sendOTPMSG91($user->phone);
            if (true || $request_id) {
                $user->msg91_request_id = $request_id;
                $user->save();
            } else {
                return response()->json([
                    'success' => false,
                    'elements' => [
                        'hide_element' => 'otp-container',
                        'show_element' => 'phone-container'
                    ],
                    'otp_not_send' => 'We are unable to send OTP please contact our team',
                    'button_message' => "Send OTP"
                ]);
            }

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
            /*if ($user->otp == $request->otp) {
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
            }*/

            if (true || $this->verifyOTPMSG91($user->msg91_request_id, $request->otp)) {
                $user->is_registered = 1;
                $user->otp = null;
                $user->msg91_request_id = null;
                $user->save();

                /**
                 * if student refered by institute but not institute student
                 * then we will give 15 rs prepaid we need to collect this amount to institute
                 */
                if($request->hasCookie('institute')) {
                    $institute_logo = json_decode($request->cookie('institute'));
                    $institute_id = Institute::where('logo', $institute_logo->logo)->value('id');
                    $user->institute_id = $institute_id;
                    $user->restart_wallet = 2;
                    $user->is_outside_institute_reference = 1;
                    $user->save();

                    $recharge = new Recharge;
                    $recharge->user_id = $user->id;
                    $recharge->amount = 15;
                    $recharge->order_id = date("Ymd")."R";
                    $recharge->razorpay_order_id = "Welcome bonus";
                    $recharge->payment_status = 1;
                    $recharge->save();
        
                    $wallet = new Wallet;
                    $wallet->user_id = $recharge->user_id;
                    $wallet->recharge_id = $recharge->id;
                    $wallet->amount = 15;
                    $wallet->save();
                }

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
            if ($request->filled('affiliate_code')) {
                $affiliate_id = Affiliate::where('affiliate_code', $request->affiliate_code)->value('id');
                $user->affiliate_id = $affiliate_id;
                $user->shared_code = $request->affiliate_code;
            }
            $user->password = Hash::make($request->password);
            $user->save();
            
            if (!is_null($user->affiliate_id)) {
                $affiliate = Affiliate::find($affiliate_id);
                Mail::to($affiliate->email)->send(
                    new StudentRegistrationMail($user, $affiliate->name)
                );
            }
            $request->session()->forget('otp_verified');
            Auth::login($user);

            return response()->json([
                'success' => true,
                'redirect_url' => route('student.dashboard')
            ]);
        }
    }

    public function forgotPasswordView(Request $request)
    {
        $institute = null;
        if($request->hasCookie('institute')) {
            $institute = json_decode($request->cookie('institute'));
        }
        return view('student.auth.forgot-password', compact(
            'institute'
        ));   
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

                // $user->otp = rand(111111, 999999);
                // $user->save();

                $request_id = $this->sendOTPMSG91($user->phone);

                if ($request_id) {

                    $user->msg91_request_id = $request_id;
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
                    'error_message' => "We are not unable to send OTP Please contact our support team."
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
            /*if ($user->otp == $request->otp) {

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
            }*/

            if ($this->verifyOTPMSG91($user->msg91_request_id, $request->otp)) {
                $request->session()->put('otp_verified', $user->id);
                $request->session()->forget('otp_send');
                
                $user->msg91_request_id = null;
                $user->save();

                return response()->json([
                    'success' => false,
                    'elements' => [
                        'hide_element' => 'otp-container',
                        'show_element' => 'forgot-passowrd-container'
                    ],
                    'button_message' => "Submit"
                ]);
            }

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
            return redirect()->route('student.mains-evaluation');
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
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget('is_institute_temporary_login');
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

            
            // $user->otp = rand(111111, 999999);
            // $user->save();

            $request_id = $this->sendOTPMSG91($user->phone);

            if ($request_id) {

                $user->msg91_request_id = $request_id;
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
                'error_message' => "We are not able to resend otp please contact our support team."
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

    public function checkAffiliate(Request $request)
    {
        if ($request->filled('affiliate_code')) {
            return response()->json(
                Affiliate::where('affiliate_code', $request->affiliate_code)->exists()
            );
        }
    }
    
    private function sendOTPMSG91(string $phone)
    {
        $payload = array(
			'widgetId' => '3569646a5a61313635393134',
			'identifier' => '91'.$phone
		);
		
		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL => "https://api.msg91.com/api/v5/widget/sendOtp",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($payload),
			CURLOPT_HTTPHEADER => [
				"authkey: 467592AR5ETBnB1pj68bab71aP1",
				"content-type: application/json"
			],
		]);

		$response = json_decode(curl_exec($curl));
		$err = curl_error($curl);

		curl_close($curl);

        if (isset($response->message) && $response->message != "") {
            return $response->message;
        }
        return false;
    }

    private function verifyOTPMSG91(string $request_id, string $otp)
    {
        $payload = array(
			"widgetId" => '3569646a5a61313635393134',
			'reqId' => $request_id,
			'otp' => $otp
		);
		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL => "https://api.msg91.com/api/v5/widget/verifyOtp",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($payload),
			CURLOPT_HTTPHEADER => [
				"authkey: 467592AR5ETBnB1pj68bab71aP1",
				"content-type: application/json"
			],
		]);

		$response = json_decode(curl_exec($curl));
		$err = curl_error($curl);

		curl_close($curl);

        if (isset($response->type) && $response->type == "success") {
            return true;
        }
        return false;
    }
}
