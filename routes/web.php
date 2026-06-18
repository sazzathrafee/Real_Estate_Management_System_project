<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VisitRequestController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminPropertyController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [PropertyController::class, 'index'])->name('home');
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/search', [PropertyController::class, 'search'])->name('properties.search');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Seller routes
    Route::middleware('seller')->group(function () {
        Route::post('/dashboard/seller', [DashboardController::class, 'sellerDashboard'])->name('seller.dashboard');
        Route::get('/seller/dashboard', [DashboardController::class, 'sellerDashboard'])->name('dashboard.seller');
        Route::resource('/seller/properties', PropertyController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::get('/seller/properties/{property}', [PropertyController::class, 'show'])->name('seller.properties.show');
        Route::get('/seller/visits', [VisitRequestController::class, 'sellerIndex'])->name('visits.seller.index');
        Route::post('/visits/{visitRequest}/approve', [VisitRequestController::class, 'approve'])->name('visits.approve');
        Route::post('/visits/{visitRequest}/reject', [VisitRequestController::class, 'reject'])->name('visits.reject');
        Route::post('/visits/{visitRequest}/complete', [VisitRequestController::class, 'complete'])->name('visits.complete');
    });

    // Buyer routes
    Route::middleware('buyer')->group(function () {
        Route::get('/buyer/dashboard', [DashboardController::class, 'buyerDashboard'])->name('dashboard.buyer');
        Route::post('/properties/{property}/visit-request', [VisitRequestController::class, 'store'])->name('visit-requests.store');
        Route::get('/buyer/visits', [VisitRequestController::class, 'buyerIndex'])->name('visits.buyer.index');
        Route::get('/buyer/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
        Route::post('/favorites/{property}', [FavoriteController::class, 'store'])->name('favorites.store');
        Route::delete('/favorites/{property}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    });

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
        
        // User management
        Route::resource('/users', UserController::class);
        
        // Category management
        Route::resource('/categories', CategoryController::class);
        
        // Property approval
        Route::get('/properties', [AdminPropertyController::class, 'index'])->name('properties.index');
        Route::get('/properties/pending', [AdminPropertyController::class, 'pending'])->name('properties.pending');
        Route::get('/properties/{property}', [AdminPropertyController::class, 'show'])->name('properties.show');
        Route::post('/properties/{property}/approve', [AdminPropertyController::class, 'approve'])->name('properties.approve');
        Route::post('/properties/{property}/reject', [AdminPropertyController::class, 'reject'])->name('properties.reject');
        
        // Visit requests
        Route::get('/visits', [VisitRequestController::class, 'adminIndex'])->name('visits.index');
    });
});

require __DIR__.'/auth.php';

