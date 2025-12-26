<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    UserAttemptQuestion,
    Recharge,
    Wallet
};

class ScreeningQuestionController extends Controller
{
    public function attemptQuestion(Request $request)
    {
        if ($request->filled('question')) {
            foreach ($request->question as $question_id => $answer) {
                $user_attempt_questions = new UserAttemptQuestion;
                $user_attempt_questions->user_id = Auth::id();
                $user_attempt_questions->question_id = $question_id;
                $user_attempt_questions->answer = $answer;
                $user_attempt_questions->save();
            }
            $user = Auth::user();
            $user->question_attempted = 1;
            $user->save();

            $welcome_bonus_exists = Recharge::where('user_id', Auth::id())
                                            ->where('razorpay_order_id', "Welcome bonus")
                                            ->exists();
                                            
            if(!$welcome_bonus_exists){
                $recharge = new Recharge;
                $recharge->user_id = Auth::id();
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
        }

        return redirect()->route('student.mains-evaluation');
    }
}
