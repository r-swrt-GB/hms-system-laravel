<?php


use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LecturerManagementController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModuleManagementController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SubmissionsController;
use App\Http\Controllers\StudentManagementController;
use Illuminate\Support\Facades\Route;

//Landing page route
Route::get('/', [LandingPageController::class, 'index'])->name('pages.landing-page');

//Login page routes
Route::get('/login', [LoginController::class, 'index'])->name('pages.login.index');

//Register page route
Route::get('/register', [RegisterController::class, 'index'])->name('pages.register.index');

// Authenticated routes
Route::middleware('auth')->group(function () {

    Route::prefix('/modules/{module}')->group(function () {

        //Submissions routes
        Route::get('/submissions', [SubmissionsController::class, 'index'])->name('pages.submissions');
        Route::get('/submissions/{submission}', [AssignmentsController::class, 'getSubmissionPage'])->name('pages.submission');

        //Assignments routes
        Route::get('/assignments', [AssignmentsController::class, 'index'])->name('pages.assignments');
        Route::get('/assignments/{assignment}', [AssignmentsController::class, 'getViewAssignmentPage'])->name('pages.assignment');
        Route::get('/assignments/create', [AssignmentsController::class, 'getCreateAssignmentPage'])->name('pages.create-assignments');

    });

    //Management routes
    Route::prefix('/management}')->group(function () {

        //Modules Management
        Route::get('/modules', [ModuleManagementController::class, 'index'])->name('pages.management-modules');

        //Students Management
        Route::get('/students', [StudentManagementController::class, 'index'])->name('pages.management-students');

        //Lecturer Management
        Route::get('/lecturer', [LecturerManagementController::class, 'index'])->name('pages.management-lecturer');

        //Admins Management
        Route::get('/admins', [AdminManagementController::class, 'index'])->name('pages.management-admins');

    });
});

require __DIR__ . '/auth.php';
