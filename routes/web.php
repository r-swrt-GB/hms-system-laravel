<?php


use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LecturerManagementController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModuleManagementController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SubmissionsController;
use App\Http\Controllers\StudentManagementController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


// Authenticated routes
Route::middleware('auth')->group(function () {

    Route::get('/assignments', [AssignmentsController::class, 'index'])->name('pages.assignments');

    Route::get('/', [LandingPageController::class, 'index'])->name('pages.landing-page');

    Route::get('/submissions', [SubmissionsController::class, 'index'])->name('pages.submissions-page');
    Route::get('/assignments/create', [AssignmentsController::class, 'getCreateAssignmentPage'])->name('pages.create-assignments');
    Route::get('/assignments/{assignment}', [AssignmentsController::class, 'getViewAssignmentPage'])->name('pages.assignment');
    Route::get('/management/students', [StudentManagementController::class, 'index'])->name('pages.management-students');

    Route::get('/management/modules', [ModuleManagementController::class, 'index'])->name('pages.management-modules');

    Route::get('/management/admins', [AdminManagementController::class, 'index'])->name('pages.management-admins');

    Route::get('/management/lecturer', [LecturerManagementController::class, 'index'])->name('pages.management-lecturer');


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
