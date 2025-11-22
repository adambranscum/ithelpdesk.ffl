<?php

declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\SopController;
use App\Http\Controllers\TicketStatsController;
use App\Http\Controllers\DeviceStatsController;
use App\Http\Controllers\SoftwareStatsController;
use App\Http\Controllers\CreateTicketController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| These routes are ONLY accessible on tenant domains (subdomains).
| The middleware ensures tenancy is initialized and prevents access
| from central domains.
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    
    /*
    |--------------------------------------------------------------------------
    | Public Tenant Routes (No Auth Required)
    |--------------------------------------------------------------------------
    */
    
    // Root - redirect based on auth status
    Route::get('/', function () {
        if (auth()->check()) {
            return redirect('/tickets');
        }
        return redirect('/login');
    })->name('tenant.home');
    
    // Auth routes are included from routes/auth.php via the web middleware
    
    /*
    |--------------------------------------------------------------------------
    | Authenticated Tenant Routes
    |--------------------------------------------------------------------------
    */
    
    Route::middleware(['auth'])->group(function () {
        
        // Dashboard (redirects to tickets)
        Route::get('/dashboard', function () {
            return redirect('/tickets');
        })->name('dashboard');
        
        /*
        |--------------------------------------------------------------------------
        | Profile Management
        |--------------------------------------------------------------------------
        */
        
        Route::prefix('profile')->name('tenant.profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'edit'])->name('edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        });
        
        /*
        |--------------------------------------------------------------------------
        | Tenant Admin - User Management
        |--------------------------------------------------------------------------
        */
        
        Route::middleware('tenant.admin')
            ->prefix('manage-users')
            ->name('tenant-admin.')
            ->group(function () {
                Route::get('/', [UserManagementController::class, 'index'])->name('users.index');
                Route::get('/create', [UserManagementController::class, 'create'])->name('users.create');
                Route::post('/', [UserManagementController::class, 'store'])->name('users.store');
                Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
                Route::patch('/{user}', [UserManagementController::class, 'update'])->name('users.update');
                Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
                Route::post('/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.reset-password');
            });
        
        /*
        |--------------------------------------------------------------------------
        | Tickets - Regular User Access
        |--------------------------------------------------------------------------
        */
        
        Route::prefix('tickets')->name('tickets.')->group(function () {
            Route::get('/stats', [TicketStatsController::class, 'index'])->name('stats');
            Route::get('/', [TicketController::class, 'index'])->name('index');
            Route::get('/{ticket}', [TicketController::class, 'show'])->name('show');
            Route::patch('/{ticket}/status', [TicketController::class, 'updateStatus'])->name('updateStatus');
            Route::patch('/{ticket}/transfer', [TicketController::class, 'transfer'])->name('transfer');
            Route::patch('/{ticket}', [TicketController::class, 'update'])->name('update');
            Route::post('/{ticket}/comment', [TicketController::class, 'addComment'])->name('addComment');
        });
        
        // Ticket Creation (separate routes for clarity)
        Route::get('/create', [CreateTicketController::class, 'create'])->name('tickets.create');
        Route::post('/store', [CreateTicketController::class, 'store'])->name('tickets.store');
        
        /*
        |--------------------------------------------------------------------------
        | Admin Ticket Management
        |--------------------------------------------------------------------------
        */
        
        Route::middleware('can.admin')
            ->prefix('admin/tickets')
            ->name('admin.')
            ->group(function () {
                Route::get('/', [AdminController::class, 'index'])->name('index');
                Route::get('/{ticket}', [AdminController::class, 'show'])->name('show');
                Route::patch('/{ticket}/status', [AdminController::class, 'updateStatus'])->name('updateStatus');
                Route::patch('/{ticket}', [AdminController::class, 'update'])->name('update');
                Route::post('/{ticket}/comment', [AdminController::class, 'addComment'])->name('addComment');
                Route::patch('/{ticket}/transfer', [AdminController::class, 'transfer'])->name('transfer');
            });
        
        /*
        |--------------------------------------------------------------------------
        | Device Management
        |--------------------------------------------------------------------------
        */
        
        Route::get('/devices/statistics', [DeviceStatsController::class, 'index'])->name('devices.stats');
        Route::resource('devices', DeviceController::class);
        
        /*
        |--------------------------------------------------------------------------
        | Software Management
        |--------------------------------------------------------------------------
        */
        
        Route::get('/software/statistics', [SoftwareStatsController::class, 'index'])->name('software.stats');
        Route::resource('software', SoftwareController::class);
        
        /*
        |--------------------------------------------------------------------------
        | Standard Operating Procedures (SOPs)
        |--------------------------------------------------------------------------
        */
        
        Route::resource('sops', SopController::class);
        Route::post('sops/{sop}/link-ticket', [SopController::class, 'linkToTicket'])->name('sops.linkTicket');
    });
});