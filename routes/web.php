<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\BooksController;
use App\Http\Controllers\Dashboard\AuthorsController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\Dashboard\OrdersController;
use App\Http\Controllers\Dashboard\BorrowsController;
use App\Http\Controllers\Dashboard\BookRequestsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LocalizationController;

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

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});

// مسارات لوحة التحكم (تتطلب تسجيل الدخول وأن يكون المستخدم admin)
Route::middleware(['auth', 'is_admin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::resource('books', BooksController::class);
    Route::resource('authors', AuthorsController::class);
    Route::resource('categories', CategoriesController::class);
    Route::resource('users', UsersController::class);
    Route::resource('orders', OrdersController::class);
    Route::resource('borrows', BorrowsController::class);
    Route::resource('book_requests', BookRequestsController::class);

    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/', 'update')->name('update');
    });
});

// مسارات تسجيل الدخول والتسجيل وتسجيل الخروج
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login');
    Route::get('register', 'showRegisterForm')->name('register');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->name('logout');
});

// تبديل اللغة
Route::get('lang/{locale}', [LocalizationController::class, 'setLang'])->name('lang.switch');
