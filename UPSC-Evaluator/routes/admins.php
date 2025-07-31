<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
	AuthController,
	DashboardController,
	UsersController,
	TestController
};

Route::middleware('guest:admin')->group(function () {
	Route::view('login', 'admin.auth.login')->name('login');
	Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::middleware('auth:admin')->group(function(){

	Route::controller(DashboardController::class)->group(function(){
		Route::prefix('dashboard')->group(function(){
			Route::get('', 'index')->name('dashboard');
		});
	});

	Route::controller(UsersController::class)->group(function(){
		Route::prefix('users')->group(function(){
			Route::get('', 'index')->name('users');
			Route::get('/{id}/attempted-question', 'getAttemptedQuestion')->name('users.attemtedQuestion');
		});
	});

	Route::get('/test', [TestController::class, 'index']);
});