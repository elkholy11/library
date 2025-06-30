<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\AuthorController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\BorrowController;
use App\Http\Controllers\API\BookRequestController;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// API v1 routes
Route::prefix('v1')->group(function () {
    // Auth routes
    Route::controller(AuthController::class)->prefix('auth')->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::middleware('auth:sanctum')->post('/logout', 'logout');
    });

    // Public Book, Category, Author routes
    Route::controller(BookController::class)->prefix('books')->group(function () {
        Route::get('/', 'index');
        Route::get('/search', 'search');
        Route::get('/{book}', 'show');
    });

    Route::controller(CategoryController::class)->prefix('categories')->group(function () {
        Route::get('/', 'index');
        Route::get('/{category}', 'show');
    });

    Route::controller(AuthorController::class)->prefix('authors')->group(function () {
        Route::get('/', 'index');
        Route::get('/{author}', 'show');
    });

    // Protected User Routes (auth:sanctum)
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('orders', OrderController::class);
        Route::apiResource('borrows', BorrowController::class);
        Route::apiResource('book-requests', BookRequestController::class);
        // يمكنك إضافة المزيد من المسارات الخاصة بالمستخدم هنا
    });
});

// Default route for testing
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
