<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Institute\{
    AuthController,
    StudentController,
    ModelAnswerController,
    ProfileController
};

Route::middleware('guest:institute')->group(function () {
	Route::view('login', 'admin.auth.login')->name('login');
	Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::middleware('auth:institute')->group(function(){
    
    // students
    Route::controller(StudentController::class)->group(function(){
        Route::prefix('students')->group(function(){
            Route::get('', 'index')->name('students');
            Route::get('/{user_id}/login', 'loginStudentAccount')->name('students.loginStudentAccount');
        });
    });

    // Model Answer
    Route::controller(ModelAnswerController::class)->group(function(){
        Route::prefix('model-answer')->group(function(){
            Route::get('', 'index')->name('model-answer');
            Route::get('/add', 'add')->name('model-answer.add');
            Route::post('/create', 'create')->name('model-answer.create');
            Route::get('/{task_id}/proces', 'processTask')->name('model-answer.processTask');
            Route::get('/view/{id}', 'view')->name('model-answer.view');
            Route::get('/delete/{id}', 'delete')->name('model-answer.delete');
        });
    });
    
    // Profile
    Route::controller(ProfileController::class)->group(function(){
        Route::prefix('profile')->group(function(){
            Route::get('/', 'index')->name('profile');
            Route::post('/update', 'update')->name('profile.update');
        });
    });

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});