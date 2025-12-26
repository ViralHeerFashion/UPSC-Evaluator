<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Middleware\EnsureScreeningQuestionCompleted;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function(){
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admins.php'));

            Route::middleware('web')
                ->prefix('institute')
                ->name('institute.')
                ->group(base_path('routes/institutes.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'question_attemp' => EnsureScreeningQuestionCompleted::class
        ])
        ->redirectGuestsTo(function(Request $request){
            if ($request->is('admin/*')) return '/admin/login';
            if ($request->is('institute/*')) return '/institute/login';
            return '/login';
        })
        ->redirectUsersTo(function(Request $request): string {
            if ($request->is('admin/*') && Auth::guard('admin')->check()) {
                return '/admin/dashboard';
            }
            if ($request->is('institute/*') && Auth::guard('institute')->check()) {
                return '/institute/students';
            }
            return Auth::check()
                ? '/mains-evaluation/start'
                : '/login';
        })
        ->validateCsrfTokens(except: [
            '/webhook/recharge/verify-payment',
            '/recharge/verify-payment'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
