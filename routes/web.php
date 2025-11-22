<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantRegistrationController;
use App\Http\Controllers\TenantManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Central Domain Routes
|--------------------------------------------------------------------------
| 
| These routes are ONLY for central domains (127.0.0.1, localhost, 
| thecommunityhelpdesk.org). They are automatically restricted to central
| domains by the RouteServiceProvider.
|
*/

// Homepage
Route::get('/', function() {
    return view('welcome');
})->name('home');

// Tenant Registration (Public)
Route::middleware('guest')->group(function () {
    Route::get('/register-library', [TenantRegistrationController::class, 'create'])->name('tenant.register');
    Route::post('/register-library', [TenantRegistrationController::class, 'store'])->name('tenant.store');
    Route::get('/registration-pending', [TenantRegistrationController::class, 'pending'])->name('tenant.pending');
});

// Super Admin Routes
Route::middleware(['auth', 'super.admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/tenants', [TenantManagementController::class, 'index'])->name('tenants.index');
    Route::get('/tenants/{tenant}', [TenantManagementController::class, 'show'])->name('tenants.show');
    Route::post('/tenants/{tenant}/approve', [TenantManagementController::class, 'approve'])->name('tenants.approve');
    Route::post('/tenants/{tenant}/suspend', [TenantManagementController::class, 'suspend'])->name('tenants.suspend');
    Route::post('/tenants/{tenant}/activate', [TenantManagementController::class, 'activate'])->name('tenants.activate');
    Route::delete('/tenants/{tenant}', [TenantManagementController::class, 'destroy'])->name('tenants.destroy');
    
    // Profile for super admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes (login, register, password reset)
// These are loaded here so they work on central domain
require __DIR__.'/auth.php';