<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
        if (
            request()->routeIs('student.*') && !Auth::user()->question_attempted && !is_null(Auth::user()->plain_password) && !in_array(Route::currentRouteName(), ['student.profile.security', 'student.profile.update-password']) ||
            (!Auth::user()->question_attempted && is_null(Auth::user()->plain_password))
        ) {
            $screen_questions = ScreeningQuestion::with('user_attempt_question')->get();

            return response()->view('student.screening-question.index', compact(
                'screen_questions'
            ));
        }
        return $next($request);
    }
}
