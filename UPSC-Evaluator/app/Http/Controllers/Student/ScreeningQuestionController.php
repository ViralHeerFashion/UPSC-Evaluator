<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserAttemptQuestion;

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
        }

        return redirect()->route('student.dashboard');
    }
}
