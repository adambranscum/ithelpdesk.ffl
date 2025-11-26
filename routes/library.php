<?php

use App\Http\Controllers\LibraryRegistrationController;
use App\Http\Controllers\LibraryAdminController;
use App\Http\Controllers\LibraryCategoryController;
use Illuminate\Support\Facades\Route;

// Public library registration routes
Route::middleware('guest')->group(function () {
    Route::get('register', [LibraryRegistrationController::class, 'showRegistrationForm'])->name('library.register.form');
    Route::post('register', [LibraryRegistrationController::class, 'register'])->name('library.register');
});

// Pending approval route (for users after registration)
Route::get('pending', [LibraryRegistrationController::class, 'pending'])->name('library.pending')->middleware('auth');

// Protected library admin routes
Route::middleware(['auth', 'verified', 'library.approved'])->group(function () {
    // Admin dashboard
    Route::get('admin/dashboard', [LibraryAdminController::class, 'dashboard'])->name('library.admin.dashboard');

    // Settings
    Route::get('admin/settings', [LibraryAdminController::class, 'editSettings'])->name('library.admin.settings');
    Route::post('admin/settings', [LibraryAdminController::class, 'updateSettings'])->name('library.admin.settings.update');

    // Staff management
    Route::get('admin/staff', [LibraryAdminController::class, 'manageStaff'])->name('library.admin.staff');
    Route::get('admin/staff/create', [LibraryAdminController::class, 'showCreateStaff'])->name('library.admin.staff.create');
    Route::post('admin/staff', [LibraryAdminController::class, 'createStaff'])->name('library.admin.staff.store');
    Route::get('admin/staff/{id}/edit', [LibraryAdminController::class, 'editStaff'])->name('library.admin.staff.edit')->where('id', '[0-9]+');
    Route::post('admin/staff/{id}/update', [LibraryAdminController::class, 'updateStaff'])->name('library.admin.staff.update')->where('id', '[0-9]+');
    Route::post('admin/staff/{member}/deactivate', [LibraryAdminController::class, 'deactivateStaff'])->name('library.admin.staff.deactivate')->where('member', '[0-9]+');
    Route::post('admin/staff/{member}/reactivate', [LibraryAdminController::class, 'reactivateStaff'])->name('library.admin.staff.reactivate')->where('member', '[0-9]+');

    // Branding preview
    Route::get('admin/branding-preview', [LibraryAdminController::class, 'brandingPreview'])->name('library.admin.branding-preview');

    // Category management
    Route::get('admin/categories', [LibraryCategoryController::class, 'index'])->name('library.admin.categories.index');
    Route::post('admin/categories', [LibraryCategoryController::class, 'store'])->name('library.admin.categories.store');
    Route::patch('admin/categories/{category}/toggle-active', [LibraryCategoryController::class, 'toggleActive'])->name('library.admin.categories.toggleActive');
    Route::delete('admin/categories/{category}', [LibraryCategoryController::class, 'destroy'])->name('library.admin.categories.destroy');
});
