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
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'question_attemp' => EnsureScreeningQuestionCompleted::class
        ])
        ->redirectGuestsTo(function(Request $request){
            return $request->is('admin/*') ? '/admin/login' : '/login';  
        })
        ->redirectUsersTo(function(Request $request): string {
            if (Auth::guard('admin')->check()) {
                return $request->is('admin/*') ? '/admin/dashboard' : '/mains-evaluation/start';
            } elseif (Auth::check()) {
                return '/mains-evaluation/start';
            }
            return '/login';
        })
        ->validateCsrfTokens(except: [
            '/recharge/verify-payment'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
