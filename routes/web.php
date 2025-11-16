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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Homepage (public)
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ticket Routes
    Route::get('/tickets/stats', [TicketStatsController::class, 'index'])->name('tickets.stats');
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    Route::patch('/tickets/{ticket}/transfer', [TicketController::class, 'transfer'])->name('tickets.transfer');
    Route::patch('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::post('/tickets/{ticket}/comment', [TicketController::class, 'addComment'])->name('tickets.addComment');
  

     // Admin Ticket Routes
    Route::get('/admin/tickets', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/tickets/{ticket}', [AdminController::class, 'show'])->name('admin.show');
    Route::patch('/admin/tickets/{ticket}/status', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');
    Route::patch('/admin/tickets/{ticket}', [AdminController::class, 'update'])->name('admin.update');
    Route::post('/admin/tickets/{ticket}/comment', [AdminController::class, 'addComment'])->name('admin.addComment');
    Route::patch('/admin/tickets/{ticket}/transfer', [AdminController::class, 'transfer'])->name('admin.transfer');

    // Redirects
	
	Route::get('/dashboard', function () {return redirect('/tickets');});
});

 // Device CRUD routes
    Route::middleware(['auth'])->group(function () {
    Route::get('/devices/statistics', [DeviceStatsController::class, 'index'])->name('devices.stats');
    Route::get('/software/statistics', [SoftwareStatsController::class, 'index'])->name('software.stats');
    Route::resource('software', SoftwareController::class);
    Route::resource('devices', DeviceController::class);
    });

Route::middleware(['auth'])->group(function () {
    Route::resource('sops', SopController::class);
    Route::post('sops/{sop}/link-ticket', [SopController::class, 'linkToTicket'])->name('sops.linkTicket');
});

   Route::middleware(['auth'])->group(function () {
   Route::get('/create', [CreateTicketController::class, 'create'])->name('tickets.create');
   Route::post('/store', [CreateTicketController::class, 'store'])->name('tickets.store');
  });

      //Error Pages
    Route::get('/403', fn() => response()->view('errors.403', [], 403))->name('errpr/403');
    Route::get('/404', fn() => response()->view('errors.404', [], 404))->name('errpr/404');
    Route::get('/419', fn() => response()->view('errors.419', [], 419))->name('errpr/419');
    Route::get('/500', fn() => response()->view('errors.500', [], 500))->name('errpr/500');
    Route::get('/503', fn() => response()->view('errors.503', [], 503))->name('errpr/503');

require __DIR__.'/auth.php';
