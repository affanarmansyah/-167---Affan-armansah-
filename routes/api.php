<?php

use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\BooksController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show'])->middleware('authloggedin');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->middleware('authloggedin');
    Route::get('users-banned', [UserController::class, 'banned']);
    Route::get('user-approve/{id}', [UserController::class, 'approve']);
    Route::get('user-unapprove/{id}', [UserController::class, 'unapprove']);
    Route::get('user-restore/{id}', [UserController::class, 'restore']);


    Route::put('auth/{id}', [ApiAuthController::class, 'update'])->middleware('authloggedin');
    Route::get('logout', [ApiAuthController::class, 'logout']);

    Route::get('dashboard', [DashboardController::class, 'index']);

    Route::get('books', [BooksController::class, 'index']);
    Route::post('store', [BooksController::class, 'store']);
    Route::patch('book/{id}', [BooksController::class, 'update']);
    Route::get('book/{id}', [BooksController::class, 'show']);
    Route::delete('book/{id}', [BooksController::class, 'destroy']);
    Route::get('book/{id}', [BooksController::class, 'restore']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
});

Route::post('login', [ApiAuthController::class, 'login']);
Route::post('register', [ApiAuthController::class, 'store']);
