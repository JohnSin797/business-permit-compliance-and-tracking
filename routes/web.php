<?php

use Illuminate\Support\Facades\Route;
use App\Services\Constant;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusinessPermitRequestController;
use App\Http\Controllers\RequirementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('{path}', function () {
    return view('welcome');
})->where('path', '.+');

Route::get('/verify-email', function() {
    view('emails.verify-email');
});

Route::prefix('user')->controller(UserController::class)->group(function() {
    Route::post('/verify-email', 'verify');
    Route::post('/resend', 'resend');
    Route::post('/update/account', 'updateAccount');
    Route::post('/update/user', 'updateUser');
});

Route::prefix('business')->controller(BusinessController::class)->group(function() {
    Route::post('/', 'index');
    Route::post('/store', 'store');
    Route::post('/admin', 'admin');
});

Route::prefix('request')->controller(BusinessPermitRequestController::class)->group(function() {
    Route::post('/', 'index');
    Route::post('/store', 'store');
    Route::post('/admin', 'admin');
});

Route::post('/barangay-list', function() {
    $barangay = Constant::barangayList();
    return response()->json([
        'barangay' => $barangay,
    ]);
});

Route::prefix('requirements')->controller(RequirementController::class)->group(function() {
    Route::post('/', 'upload');
    Route::post('/index', 'index');
});