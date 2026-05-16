<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Middleware\{
    EnsureScreeningQuestionCompleted,
    InstituteStudentResetPassword
};

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
            'question_attemp' => EnsureScreeningQuestionCompleted::class,
            'institute_student_reset_password' => InstituteStudentResetPassword::class
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
                $permission = json_decode(Auth::guard('institute')->user()->permissions);
                if (is_null($permission)) {
                    return route('institute.profile');
                }
                switch ($permission[0]) {
                    case 'model_answer':
                        return route('institute.model-answer');
        
                    case 'students':
                        return route('institute.students');
        
                    case 'bulk_pdf_process':
                        return route('institute.bulk-pdf-process');
        
                    default:
                        return route('institute.profile');
                }
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
    ->withCommands([
        base_path('app/Console/CommandsBackup'),
    ])
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('app:delete-institute-expired-evaluation-pdfs')
                ->dailyAt('19:00')
                ->timezone('Asia/Kolkata');
                
        $schedule->command('app:run-parallel-queue')
                ->everyMinute()
                ->withoutOverlapping();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
