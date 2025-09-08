<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use App\Models\{
    Recharge,
    Error,
    Wallet
};

class RechargeController extends Controller
{
    public function index()
    {
        return view('student.recharge.index');
    }

    public function createOrder(Request $request)
    {
        $order_id = date("Ymd").Auth::id().rand(111, 999);
        $api = new Api(config('razorpay.api_key'), config('razorpay.api_secret'));
        $order = $api->order->create(array(
            'receipt' => $order_id, 
            'amount' => $request->amount * 100, 
            'currency' => 'INR', 
            'notes'=> [
                'website' => $request->getHost()
            ]
        ));
        $recharge = new Recharge;
        $recharge->user_id = Auth::id();
        $recharge->amount = $request->amount;
        $recharge->order_id = $order_id;
        $recharge->razorpay_order_id = $order->id;
        $recharge->save();

        return response()->json([
            'order_id' => $order_id,
            'razorpay_order_id' => $recharge->razorpay_order_id,
            'amount' => $recharge->amount * 100,
            'callback_url' => route('student.recharge.verifyPayment')
        ]);
    }

    public function verifyPayment(Request $request)
    {
        $api = new Api(config('razorpay.api_key'), config('razorpay.api_secret'));

        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ];

        $recharge = Recharge::where('razorpay_order_id', $request->razorpay_order_id)
                            ->where('user_id', Auth::id())
                            ->first();

        try {
            $api->utility->verifyPaymentSignature($attributes);

            $recharge->razorpay_payment_id = $request->razorpay_payment_id;
            $recharge->razorpay_signature = $request->razorpay_signature;
            $recharge->save();

        } catch (SignatureVerificationError $e) {

            $recharge->payment_status = 2;
            $recharge->save(); 

            $error = new Error;
            $error->message = "Payment signature verification failed.";
            $error->error = $e->getMessage();
            $error->file_name = __FILE__;
            $error->line_number = __LINE__;
            $error->save();
        }

        return redirect()->route('student.recharge.detail', ['order_id' => $recharge->order_id]);
    }

    public function paymentStatus(Request $request)
    {
        $webhook_secret = "!!++AspireScan@2025";
        $api = new Api(config('razorpay.api_key'), config('razorpay.api_secret'));
        $data = $api->utility->verifyWebhookSignature($request->getContent(), $request->header('X-Razorpay-Signature'), $webhook_secret);
        $payment_detail = json_decode($request->getContent());
        $razorpay_order_id = $payment_detail->payload->payment->entity->order_id;
        $recharge = Recharge::where('razorpay_payment_id', $order_id)->first();
        if (!is_null($recharge)) {
            if(
                $payment_detail->event == "payment.captured" && 
                $payment_detail->payload->payment->entity->currency == 'INR' && 
                $payment_detail->payload->payment->entity->amount == ($recharge->amount * 100) && 
                $payment_detail->payload->payment->entity->status == "captured"
            ) {
                $recharge->payment_status = 1;
                $recharge->save();

                $recharge_amount = $recharge->amount;
                if ($recharge_amount == 349) {
                    $recharge_amount = 405;
                } elseif($recharge_amount == 799) {
                    $recharge_amount = 1125;
                } elseif($recharge_amount == 1299) {
                    $recharge_amount = 2025;
                }

                $wallet = new Wallet;
                $wallet->user_id = $recharge->user_id;
                $wallet->recharge_id = $recharge->id;
                $wallet->amount = $recharge_amount;
                $wallet->save();
                
            } else {
                $error = new Error;
                $error->message = "Webhook called signature verified but something went wrong";
                $error->error = $request->getContent();
                $error->file_name = __FILE__;
                $error->line_number = __LINE__;
                $error->save();
            }
        } else {
            $error = new Error;
            $error->message = "Webhook called but recharge not found";
            $error->error = $request->getContent();
            $error->file_name = __FILE__;
            $error->line_number = __LINE__;
            $error->save();
        }

    }

    public function detail(string $order_id)
    {
        $recharge = Recharge::where('order_id', $order_id)
                            ->where('user_id', Auth::id())
                            ->first();

        return view('student.recharge.detail', compact(
            'recharge'
        ));
    }
}
