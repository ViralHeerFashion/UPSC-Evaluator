<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    ScreeningQuestion
};

class EnsureScreeningQuestionCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (request()->routeIs('student.*') && !Auth::user()->question_attempted) {
            $screen_questions = ScreeningQuestion::with('user_attempt_question')->get();

            return response()->view('student.screening-question.index', compact(
                'screen_questions'
            ));
        }
        return $next($request);
    }
}
