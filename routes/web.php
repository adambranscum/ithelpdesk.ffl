<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\SopController;
use App\Http\Controllers\TicketStatsController;
use App\Http\Controllers\DeviceStatsController;
use App\Http\Controllers\SoftwareStatsController;
use App\Http\Controllers\CreateTicketController;
use App\Http\Controllers\TenantRegistrationController;
use App\Http\Controllers\TenantManagementController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Central Domain Routes (Main Application)
|--------------------------------------------------------------------------
| These routes should NOT use tenant middleware
*/

// Homepage (public) - Central domain only
Route::get('/', function() {
    return view('welcome');
})->name('home');

// Tenant Registration Routes (Public)
Route::middleware('guest')->group(function () {
    Route::get('/register-library', [TenantRegistrationController::class, 'create'])->name('tenant.register');
    Route::post('/register-library', [TenantRegistrationController::class, 'store'])->name('tenant.store');
    Route::get('/registration-pending', [TenantRegistrationController::class, 'pending'])->name('tenant.pending');
});

// Super Admin Routes (Central Domain Only)
Route::middleware(['auth', 'super.admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/tenants', [TenantManagementController::class, 'index'])->name('tenants.index');
    Route::get('/tenants/{tenant}', [TenantManagementController::class, 'show'])->name('tenants.show');
    Route::post('/tenants/{tenant}/approve', [TenantManagementController::class, 'approve'])->name('tenants.approve');
    Route::post('/tenants/{tenant}/suspend', [TenantManagementController::class, 'suspend'])->name('tenants.suspend');
    Route::post('/tenants/{tenant}/activate', [TenantManagementController::class, 'activate'])->name('tenants.activate');
    Route::delete('/tenants/{tenant}', [TenantManagementController::class, 'destroy'])->name('tenants.destroy');
});

// Profile routes for super admin on central domain
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes (works on both central and tenant domains)
require __DIR__.'/auth.php';

// Error Pages (available on all domains)
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});