<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


// Authenticated routes
Route::middleware('auth')->group(function () {

    // Routes for all authenticated users (students, lecturers, and admins)
//    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

    // Lecturer-specific routes
    Route::middleware('role:lecturer')->group(function () {
//        Route::get('/lecturer/courses', [LecturerController::class, 'courses'])->name('lecturer.courses');
//        Route::get('/lecturer/feedback', [LecturerController::class, 'feedback'])->name('lecturer.feedback');
    });

    // Admin routes (Admin can access both Lecturer and additional Admin routes)
    Route::middleware('role:admin')->group(function () {
        // Admin can access all Lecturer routes
//        Route::get('/lecturer/courses', [LecturerController::class, 'courses'])->name('lecturer.courses');
//        Route::get('/lecturer/feedback', [LecturerController::class, 'feedback'])->name('lecturer.feedback');

        // Admin-specific routes
//        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
//        Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
    });

});

// Home
Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('pages.home.index');

Route::get('/', [RegisterController::class, 'index'])
    ->name('pages.register.index');

Route::get('/login', [LoginController::class, 'index'])
    ->name('pages.login.index');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

require __DIR__ . '/auth.php';
