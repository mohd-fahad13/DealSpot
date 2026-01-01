<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OwnerAuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusinessLocationController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ReviewController;

// -------------------------------
// Business Owner Auth
// -------------------------------
Route::post('/owner/register', [OwnerAuthController::class, 'register']);
Route::post('/owner/login', [OwnerAuthController::class, 'login']);

// Protected owner routes
Route::middleware('auth:sanctum')->group(function () {

    // Business
    Route::post('/business', [BusinessController::class, 'store']);
    Route::put('/business/{id}', [BusinessController::class, 'update']);
    Route::delete('/business/{id}', [BusinessController::class, 'destroy']);

    // Business Locations
    Route::post('/business/{id}/location', [BusinessLocationController::class, 'store']);
    Route::put('/location/{id}', [BusinessLocationController::class, 'update']);
    Route::delete('/location/{id}', [BusinessLocationController::class, 'destroy']);

    // Discounts
    Route::post('/discount', [DiscountController::class, 'store']);
    Route::put('/discount/{id}', [DiscountController::class, 'update']);
    Route::delete('/discount/{id}', [DiscountController::class, 'destroy']);
});

// Public APIs
Route::get('/deals', [DiscountController::class, 'publicIndex']);
Route::get('/deal/{id}', [DiscountController::class, 'publicShow']);
Route::get('/business/{id}', [BusinessController::class, 'publicShow']);
Route::get('/business/{id}/locations', [BusinessLocationController::class, 'publicLocations']);
