<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\{
    AuthController,
    DashboardController
};


Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'view')->name('student.register');
    Route::post('store', 'store')->name('student.register.store');
    Route::get('check-field', 'checkField')->name('student.register.check-field');
});

Route::get('dashboard', [DashboardController::class, 'index'])->name('student.dashboard');