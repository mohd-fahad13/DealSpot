<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Public pages
// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/deals', [App\Http\Controllers\DiscountController::class, 'publicIndex'])->name('deals.list');
Route::get('/deals/{id}', [App\Http\Controllers\DiscountController::class, 'publicShow'])->name('deals.show');
Route::get('/business/{id}', [App\Http\Controllers\BusinessController::class, 'publicShow'])->name('business.show');

// Business Owner Auth pages
Route::get('/owner/login', [App\Http\Controllers\Auth\OwnerAuthController::class, 'loginPage'])->name('owner.login.page');
Route::get('/owner/register', [App\Http\Controllers\Auth\OwnerAuthController::class, 'registerPage'])->name('owner.register.page');
