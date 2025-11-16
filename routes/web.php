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
use App\Http\Controllers\Tenant\TenantRegistrationController;
use App\Http\Controllers\SuperAdmin\TenantManagementController;
use App\Http\Controllers\TenantAdmin\UserManagementController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Central Domain Routes (Main Application)
|--------------------------------------------------------------------------
*/

// Homepage (public)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Tenant Registration Routes (Public)
Route::middleware('guest')->group(function () {
    Route::get('/register-library', [TenantRegistrationController::class, 'create'])->name('tenant.register');
    Route::post('/register-library', [TenantRegistrationController::class, 'store']);
    Route::get('/registration-pending', [TenantRegistrationController::class, 'pending'])->name('tenant.pending');
});

// Super Admin Routes (Central Domain Only)
Route::middleware(['auth', 'central'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/tenants', [TenantManagementController::class, 'index'])->name('tenants.index');
    Route::get('/tenants/{tenant}', [TenantManagementController::class, 'show'])->name('tenants.show');
    Route::post('/tenants/{tenant}/approve', [TenantManagementController::class, 'approve'])->name('tenants.approve');
    Route::post('/tenants/{tenant}/suspend', [TenantManagementController::class, 'suspend'])->name('tenants.suspend');
    Route::post('/tenants/{tenant}/activate', [TenantManagementController::class, 'activate'])->name('tenants.activate');
    Route::delete('/tenants/{tenant}', [TenantManagementController::class, 'destroy'])->name('tenants.destroy');
});

/*
|--------------------------------------------------------------------------
| Tenant Routes (Subdomain Access)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    
    Route::middleware(['auth'])->group(function () {
        // Profile Routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Tenant Admin - User Management Routes
        Route::middleware('tenant.admin')->prefix('manage-users')->name('tenant-admin.')->group(function () {
            Route::get('/', [UserManagementController::class, 'index'])->name('users.index');
            Route::get('/create', [UserManagementController::class, 'create'])->name('users.create');
            Route::post('/', [UserManagementController::class, 'store'])->name('users.store');
            Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
            Route::patch('/{user}', [UserManagementController::class, 'update'])->name('users.update');
            Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
            Route::post('/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.reset-password');
        });

        // Ticket Routes
        Route::get('/tickets/stats', [TicketStatsController::class, 'index'])->name('tickets.stats');
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
        Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
        Route::patch('/tickets/{ticket}/transfer', [TicketController::class, 'transfer'])->name('tickets.transfer');
        Route::patch('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
        Route::post('/tickets/{ticket}/comment', [TicketController::class, 'addComment'])->name('tickets.addComment');
        Route::get('/create', [CreateTicketController::class, 'create'])->name('tickets.create');
        Route::post('/store', [CreateTicketController::class, 'store'])->name('tickets.store');

        // Admin Ticket Routes (for users with admin access)
        Route::middleware('can.admin')->group(function () {
            Route::get('/admin/tickets', [AdminController::class, 'index'])->name('admin.index');
            Route::get('/admin/tickets/{ticket}', [AdminController::class, 'show'])->name('admin.show');
            Route::patch('/admin/tickets/{ticket}/status', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');
            Route::patch('/admin/tickets/{ticket}', [AdminController::class, 'update'])->name('admin.update');
            Route::post('/admin/tickets/{ticket}/comment', [AdminController::class, 'addComment'])->name('admin.addComment');
            Route::patch('/admin/tickets/{ticket}/transfer', [AdminController::class, 'transfer'])->name('admin.transfer');
        });

        // Device Routes
        Route::get('/devices/statistics', [DeviceStatsController::class, 'index'])->name('devices.stats');
        Route::resource('devices', DeviceController::class);

        // Software Routes
        Route::get('/software/statistics', [SoftwareStatsController::class, 'index'])->name('software.stats');
        Route::resource('software', SoftwareController::class);

        // SOP Routes
        Route::resource('sops', SopController::class);
        Route::post('sops/{sop}/link-ticket', [SopController::class, 'linkToTicket'])->name('sops.linkTicket');

        // Dashboard redirect
        Route::get('/dashboard', function () {
            return redirect('/tickets');
        });
    });

    // Auth routes (include for tenant domains)
    require __DIR__.'/auth.php';
});

// Error Pages (available on all domains)
Route::get('/403', fn() => response()->view('errors.403', [], 403))->name('error.403');
Route::get('/404', fn() => response()->view('errors.404', [], 404))->name('error.404');
Route::get('/419', fn() => response()->view('errors.419', [], 419))->name('error.419');
Route::get('/500', fn() => response()->view('errors.500', [], 500))->name('error.500');
Route::get('/503', fn() => response()->view('errors.503', [], 503))->name('error.503');