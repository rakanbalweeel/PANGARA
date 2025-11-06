<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Protected API routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
        // Transactions Management
    Route::prefix('transactions')->group(function () {
        Route::get('/', [\App\Http\Controllers\TransactionController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\TransactionController::class, 'store']);
        Route::get('/{id}', [\App\Http\Controllers\TransactionController::class, 'show']);
        Route::put('/{id}', [\App\Http\Controllers\TransactionController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\TransactionController::class, 'destroy']);
    });
    
    // Messages
    
    // Messages
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index']);
    Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store']);
    Route::put('/messages/{id}/read', [\App\Http\Controllers\MessageController::class, 'markAsRead']);
    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index']);
    Route::put('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead']);
    // Store Settings
    Route::get('/settings', [\App\Http\Controllers\StoreSettingController::class, 'show']);
    Route::put('/settings', [\App\Http\Controllers\StoreSettingController::class, 'update']);
    
    // Dashboard Stats
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);
    Route::get('/dashboard/sales-chart', [DashboardController::class, 'getSalesChartData']);
    
    // Pembeli (Buyer) Dashboard
    Route::get('/pembeli/stats', [DashboardController::class, 'getPembeliStats']);
    Route::get('/pembeli/purchases', [\App\Http\Controllers\TransactionController::class, 'getPurchaseHistory']);
    
    // Update authenticated user's profile
    Route::post('/user/profile', [UserController::class, 'updateProfile']);
    
    // Users Management (Admin only)
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });
    
    // Products Management
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::post('/', [ProductController::class, 'store']);
        Route::get('/{id}', [ProductController::class, 'show']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'destroy']);
    });
    
    // Categories Management
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::get('/{id}', [CategoryController::class, 'show']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
    });
});
