<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Institute\{
    AuthController,
    StudentController
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
        });
    });
    
});