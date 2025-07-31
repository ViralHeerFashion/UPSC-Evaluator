<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\{
    AuthController,
    DashboardController,
    ScreeningQuestionController,
    RechargeController,
    ProfileController,
    MainsEvaluationController
};


Route::get('/', function () {
    return view('welcome');
});

Route::post('/recharge/payment-status', [RechargeController::class, 'paymentStatus']);

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('register', 'view')->name('student.register');
        Route::post('store', 'store')->name('student.register.store');
        Route::get('check-field', 'checkField')->name('student.register.check-field');

        Route::view('login', 'student.auth.login')->name('student.login');
        Route::post('forgot-password', 'forgotPassword')->name('student.forgotPassword');
        Route::get('resend-otp', 'otpResend')->name('student.otpResend');
        Route::view('forgot-password', 'student.auth.forgot-password')->name('student.forgot-password');
        Route::post('password-login', 'passwordLogin')->name('student.passwordLogin');
    });
});

Route::middleware('auth')->group(function(){

    Route::name('student.')->group(function () {

        Route::middleware('question_attemp')->group(function(){
            Route::controller(DashboardController::class)->group(function(){
                Route::get('dashboard', 'index')->name('dashboard');
            }); 

            Route::prefix('recharge')->group(function(){
                Route::controller(RechargeController::class)->group(function(){
                    Route::get('', 'index')->name('recharge');
                    Route::get('{order_id}', 'detail')->name('recharge.detail');

                    Route::post('create-order', 'createOrder')->name('recharge.createOrder');
                    Route::post('verify-payment', 'verifyPayment')->name('recharge.verifyPayment');
                });
            });

            Route::prefix('profile')->group(function () {
                Route::controller(ProfileController::class)->group(function (){
                    Route::view('', 'student.profile.index')->name('profile'); 
                    Route::post('update', 'update')->name('profile.update');
                    Route::view('/security', 'student.profile.security')->name('profile.security');
                    Route::post('/update-password', 'updatePassword')->name('profile.update-password');

                    Route::get('/check-email', 'checkEmail')->name('profile.check-email');
                });
            });

            Route::prefix('mains-evaluation')->group(function(){
                Route::controller(MainsEvaluationController::class)->group(function(){
                    Route::get('', 'index')->name('mains-evaluation');
                    // Route::view('', 'student.mains-evaluation.index')->name('mains-evaluation');
                    Route::any('/make-evaluate', 'makeEvaluate')->name('mains-evaluation.make-evaluate');
                });
            });

            Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        });

        Route::post('attempt-question', [ScreeningQuestionController::class, 'attemptQuestion'])->name('attempt-question.attempt');
    });
});
