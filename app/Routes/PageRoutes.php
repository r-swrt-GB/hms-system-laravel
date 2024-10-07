<?php

namespace App\Routes;

use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LecturerManagementController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModuleManagementController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StudentManagementController;
use App\Http\Controllers\SubmissionsController;
use Illuminate\Support\Facades\Route;

class PageRoutes
{
    public static function get()
    {
        //Landing page route
        Route::get('/', [LandingPageController::class, 'index'])->name('pages.landing-page');

        Route::middleware('guest')->group(function () {
            Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

            //Register page route
            Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');
            Route::post('register', [RegisteredUserController::class, 'store']);
        });

        // Authenticated routes
        Route::middleware('auth:sanctum')->group(function () {

            Route::get('/home', [HomeController::class, 'index'])->name('pages.home.index');

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

    }
}
