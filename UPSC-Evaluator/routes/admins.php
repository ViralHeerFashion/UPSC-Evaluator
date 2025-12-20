<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
	AuthController,
	DashboardController,
	UsersController,
	InstituteController,
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

	Route::controller(InstituteController::class)->group(function(){
		Route::prefix('institutes')->group(function(){
			Route::get('', 'index')->name('institute');
			Route::get('/add/{uuid?}', 'add')->name('institute.add');
			Route::post('/create', 'create')->name('institute.create');
			Route::post('/upload-logo', 'uploadLogo')->name('institute.uploadLogo');
			Route::get('/delete-logo', 'deleteLogo')->name('institute.deleteLogo');
			Route::get('/{uuid}/student-sheet', 'studentSheet')->name('institute.studentSheet');
			Route::post('/{institute_id}/upload-sheet', 'uploadSheet')->name('institute.uploadSheet');
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