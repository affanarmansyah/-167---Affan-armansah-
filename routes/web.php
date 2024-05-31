<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookRentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RentLogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserRentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PublicController::class, 'index']);

Route::middleware('only_guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticating']);
    Route::get('register', [AuthController::class, 'register']);
    Route::post('register', [AuthController::class, 'registerProcess']);
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('profile', [UserController::class, 'profile'])->middleware('only_client');
    Route::get('profile-edit', [UserController::class, 'edit'])->middleware('only_client');
    Route::put('profile-edit', [UserController::class, 'update'])->middleware('only_client');

    Route::get('user-rent', [UserRentController::class, 'index']);
    Route::post('user-rent', [UserRentController::class, 'store']);
    Route::get('user-return-book', [UserRentController::class, 'return']);
    Route::post('user-return-book', [UserRentController::class, 'returnbook']);
});

Route::middleware(['only_admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index']);

    Route::get('books', [BooksController::class, 'index']);
    Route::get('book-add', [BooksController::class, 'add']);
    Route::post('book-add', [BooksController::class, 'create']);
    Route::get('book-edit/{slug}', [BooksController::class, 'edit']);
    Route::post('book-edit/{slug}', [BooksController::class, 'update']);
    Route::get('book-destroy/{slug}', [BooksController::class, 'destroy']);
    Route::get('book-restore/{slug}', [BooksController::class, 'restore']);

    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('category-add', [CategoryController::class, 'add']);
    Route::post('category-add', [CategoryController::class, 'create']);
    Route::get('category-edit/{slug}', [CategoryController::class, 'edit']);
    Route::put('category-edit/{slug}', [CategoryController::class, 'update']);
    Route::get('category-destroy/{slug}', [CategoryController::class, 'destroy']);
    Route::get('category-restore/{slug}', [CategoryController::class, 'restore']);

    Route::get('users', [UserController::class, 'index']);
    Route::get('registered-user', [UserController::class, 'registered']);
    Route::get('detail-user/{slug}', [UserController::class, 'show']);
    Route::get('user-approve/{slug}', [UserController::class, 'approve']);
    Route::get('user-unapprove/{slug}', [UserController::class, 'unapprove']);
    Route::get('destroy-user/{slug}', [UserController::class, 'destroy']);
    Route::get('restore-user/{slug}', [UserController::class, 'restore']);

    Route::get('book-rent', [BookRentController::class, 'index']);
    Route::post('book-rent', [BookRentController::class, 'store']);
    Route::get('rent-approve/{id}', [BookRentController::class, 'approve']);
    Route::get('rent-unapprove/{id}', [BookRentController::class, 'unapprove']);
    Route::get('book-return', [BooksController::class, 'return']);
    Route::post('book-return', [BooksController::class, 'returnbook']);
    Route::get('/get-book/{id}', [BooksController::class, 'getbook']);

    Route::get('rent-logs', [RentLogController::class, 'index']);
});
