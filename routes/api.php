<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusinessPermitRequestController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('user')->controller(AuthController::class)->group(function() {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
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
    Route::get('/archive/{$id}', 'archive');
});

Route::prefix('request')->controller(BusinessPermitRequestController::class)->group(function() {
    Route::get('/show/{permit}', 'show');
    Route::put('/edit/{permit}', 'edit');
    Route::patch('/delete/{permit}', 'delete');
    Route::delete('/destroy/{permit}', 'destroy');
    Route::patch('/update/{permit}', 'update');
});

Route::prefix('user')->controller(UserController::class)->group(function() {
    Route::post('/profile-image', 'changeProfileImage');
});