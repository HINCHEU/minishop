<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\AdminProductController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These routes are automatically prefixed with /api
| Example: /api/products
*/

// Products (public)
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// Orders
Route::post('/orders', [OrderController::class, 'store']);

// Admin (later add auth middleware)
Route::get('/admin/products', [AdminProductController::class, 'index']);
Route::post('/admin/products', [AdminProductController::class, 'store']);
Route::put('/admin/products/{id}', [AdminProductController::class, 'update']);
Route::delete('/admin/products/{id}', [AdminProductController::class, 'destroy']);

// Settings (shop configuration)
Route::get('/settings', [SettingsController::class, 'index']);
Route::put('/admin/settings', [SettingsController::class, 'update']);

// Comments (guest comments on products)
Route::get('/products/{productId}/comments', [CommentController::class, 'index']);
Route::post('/products/{productId}/comments', [CommentController::class, 'store']);
