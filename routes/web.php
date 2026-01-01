<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealsController;
use App\Http\Controllers\ExploreDealsController;
use App\Http\middleware\ValidBusinessOwner;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('welcome');
});

// FIXED ROUTES
Route::get('/login', [FormsController::class, 'showLogin'])->name('owner.login');
Route::post('/login', [FormsController::class, 'loginOwner'])->name('owner.login.submit');
//forget passsword
Route::get('/owner/reset-password', [FormsController::class, 'showForgotPassword'])
        ->name('owner.reset-password');
Route::post('/owner/send-otp', [FormsController::class, 'sendOtp'])->name('owner.send-otp');
Route::post('/owner/verify-otp', [FormsController::class, 'verifyOtp'])->name('owner.verify-otp');
Route::post('/owner/reset-password', [FormsController::class, 'resetPassword'])
        ->name('owner.reset-password.submit');


// Register 
Route::get('/registration', [FormsController::class, 'showRegistration'])->name('owner.register');
Route::post('/registration', [FormsController::class, 'storeBusinessOwner'])->name('owner.register.submit');

// AJAX email checker
Route::post('/check-email', [FormsController::class, 'checkEmail'])->name('owner.check.email');

// PROTECTED DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'showDashboard'])
        ->name('dashboard');
        // ->middleware(ValidBusinessOwner::class);

// LOGOUT
Route::post('/owner/logout', [DashboardController::class, 'logout'])->name('owner.logout');

// new route for business form 
// Route::get('/business/create', [BusinessController::class, 'showBusinessForm'])->name('business.create');
Route::get('/show-category', [BusinessController::class, 'showCategory'])->name('show-category');
// Route::post('/business', [BusinessController::class, 'store'])->name('business.store');
// show all businesses 
// Route::get('/businesses', [BusinessController::class, 'index'])->name('business.showAll');
Route::resource('business', BusinessController::class)->names([
    'index'   => 'business.showAll',    // GET /business
    'create'  => 'business.create',     // GET /business/create
    'store'   => 'business.store',      // POST /business
    'show'    => 'business.show',       // GET /business/{business}
    'edit'    => 'business.edit',       // GET /business/{business}/edit
    'update'  => 'business.update',     // PUT/PATCH /business/{business}
    'destroy' => 'business.destroy',    // DELETE /business/{business}
]);

// new route for business form 
// Route::get('/deal/create', [DealsController::class, 'showDealsForm'])->name('deals.create');
// Route::post('/deal', [DealsController::class, 'store'])->name('deals.store');
Route::get('/businesses-list', [DealsController::class, 'businessesList'])->name('show-businesses-list');
// Route::get('/deals/locations-list', [DealsController::class, 'locationsList'])->name('deals.locations.list');
Route::get('/deals/locations-list', [DealsController::class, 'locationsList'])->name('deals.locations.list');
// show all deals 
// Route::get('/deals', [DealsController::class, 'index'])->name('deals.showAll');
Route::resource('deals', DealsController::class)->names([
    'index'   => 'deals.showAll',
    'create'  => 'deals.create',
    'store'   => 'deals.store',
    'show'    => 'deals.show',
    'edit'    => 'deals.edit',
    'update'  => 'deals.update',
    'destroy' => 'deals.destroy',
]);

// Explore Deals routes
Route::get('/explore-deals', [ExploreDealsController::class, 'index'])->name('explore.deals');
Route::get('/get-states', [ExploreDealsController::class, 'getStates'])->name('get.states');
Route::get('/get-cities', [ExploreDealsController::class, 'getCities'])->name('get.cities');

// Contact routes
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
