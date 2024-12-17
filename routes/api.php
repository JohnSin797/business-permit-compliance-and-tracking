<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusinessPermitRequestController;
use App\Http\Controllers\NotificationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('user')->controller(AuthController::class)->group(function() {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::get('/', 'index');
});

Route::prefix('post')->controller(AnnouncementController::class)->group(function() {
    Route::get('/', 'index');
    Route::post('/store', 'store');
    Route::get('/old/{post}', 'oldPosts');
});

Route::prefix('business')->controller(BusinessController::class)->group(function() {
    Route::get('/show/{business}', 'show');
    Route::put('/edit/{business}', 'update');
    Route::patch('/delete/{business}', 'delete');
    Route::delete('/destroy/{id}', 'destroy');
    Route::post('/archive', 'archive');
    Route::patch('/restore/{id}', 'restore');
});

Route::prefix('request')->controller(BusinessPermitRequestController::class)->group(function() {
    Route::get('/show/{id}', 'show');
    Route::get('/edit/{id}', 'edit');
    Route::post('/edit', 'updatePermit');
    Route::delete('/delete/{id}', 'delete');
    Route::delete('/destroy/{id}', 'destroy');
    Route::patch('/update/{permit}', 'update');
    Route::put('/archive', 'archive');
    Route::patch('/restore/{id}', 'restore');
});

Route::prefix('user')->controller(UserController::class)->group(function() {
    Route::post('/profile-image', 'changeProfileImage');
});

Route::prefix('notification')->controller(NotificationController::class)->group(function() {
    Route::post('/show/{id}', 'show');
    Route::delete('/delete/{id}', 'delete');
    Route::patch('/update/{id}', 'update');
});