<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Weather\WeatherController;
use Illuminate\Support\Facades\Route;

// Auth
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

// Users
Route::controller(UserController::class)->group(function () {
    Route::get('/users/{user}', 'show');
    Route::get('/users', 'index');
});

// Posts (protected except index/show?) requirement says list all posts open. We'll allow public read, auth required for modify
Route::controller(PostController::class)->group(function () {
    Route::get('/posts', 'index');
    Route::get('/posts/{post}', 'show');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/posts', 'store');
        Route::patch('/posts/{post}', 'update');
        Route::delete('/posts/{post}', 'destroy');
    });
});

// Weather
Route::get('/weather', [WeatherController::class, 'show']);
