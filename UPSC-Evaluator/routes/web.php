<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Student\{
    AuthController,
    DashboardController,
    ScreeningQuestionController,
    RechargeController,
    ProfileController,
    MainsEvaluationController,
    WalletController
};


Route::get('/', function () {
    return view('welcome');
});

Route::view('/', 'pages.home')->name('home');
Route::view('/about-us', 'pages.about-us')->name('about-us');
Route::view('/contact-us', 'pages.contact-us')->name('contact-us');
Route::post('/contact-us/create', [ContactUsController::class, 'create'])->name('contact-us.create');
Route::view('/privacy-policy', 'pages.privacy-policy')->name('privacy-policy');
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/disclaimer', 'pages.disclaimer')->name('disclaimer');

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
                    Route::get('/start/{process_id?}', 'index')->name('mains-evaluation');
                    Route::get('list', 'list')->name('mains-evaluation.list');
                    // Route::view('', 'student.mains-evaluation.index')->name('mains-evaluation');
                    Route::any('/make-evaluate', 'makeEvaluate')->name('mains-evaluation.make-evaluate');

                    // Viral
                    Route::post('/generate-task', 'generateTask')->name('mains-evaluation.generate-task');
                    Route::post('/{task_id}/process-task', 'processTask')->name('mains-evaluation.process-task');
                    Route::get('/{task_id}/download-evaluation', 'downloadEvaluation')->name('mains-evaluation.download-evaluation');
                });
            });

            Route::prefix('wallet')->group(function(){
                Route::controller(WalletController::class)->group(function(){
                    Route::get('', 'index')->name('wallet');
                });
            });

            Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        });

        Route::post('attempt-question', [ScreeningQuestionController::class, 'attemptQuestion'])->name('attempt-question.attempt');
    });
});
