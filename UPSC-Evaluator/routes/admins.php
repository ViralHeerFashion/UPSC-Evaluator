<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
	AuthController,
	DashboardController,
	UsersController,
	InstituteController,
	TestController,
	AffiliateController,
	BulkPDFProcessController,
	PrepaidWalletController
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
			Route::post('/feature-permission', 'featurePermission')->name('institute.featurePermission');

			Route::get('/{uuid}/recharge/{id?}', 'recharge')->name('institute.recharge');
			Route::post('/{uuid}/make-recharge', 'makeRecharge')->name('institute.makeRecharge');
			Route::get('/{uuid}/recharge/{id}/delete', 'deleteRecharge')->name('institute.deleteRecharge');

			Route::get('/{institute_id}/delete', 'delete')->name('institute.delete');
		});
	});

	Route::controller(UsersController::class)->group(function(){
		Route::prefix('users')->group(function(){
			Route::get('', 'index')->name('users');
			Route::get('/{id}/attempted-question', 'getAttemptedQuestion')->name('users.attemtedQuestion');

			Route::post('/{institute_uuid}/distribute-recharge', 'distributeRecharge')->name('institute.distributeRecharge');
			Route::get('/{id}/{status}/change-status', 'changeStatus')->name('users.changeStatus');
		});
	});

	Route::controller(BulkPDFProcessController::class)->group(function(){
		Route::prefix('bulk-pdf-process')->group(function(){
			Route::get('', 'index')->name('bulk-pdf-process');
		});
	});
	
	Route::controller(AffiliateController::class)->group(function(){
		Route::prefix('affiliate')->group(function(){
			Route::get('', 'index')->name('affiliate');
			Route::post('/create', 'create')->name('affiliate.create');
			Route::get('/{id}/delete', 'delete')->name('affiliate.delete');
		});
	});

	Route::controller(PrepaidWalletController::class)->group(function(){
		Route::prefix('prepaid-wallets')->group(function(){
			Route::get('/', 'index')->name('prepaid-wallet');
			Route::post('/make-paid', 'makePaid')->name('makePaid');
		});
	});

	Route::get('/test', [TestController::class, 'index']);
});