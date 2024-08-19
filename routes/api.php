<?php


use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ModuleManagementController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionsController;
use Illuminate\Support\Facades\Route;

// Authenticated requests
Route::middleware('auth')->group(function () {


    //Module
    //Create
    Route::post('/create', [ModuleManagementController::class, 'create'])->name('api.modules.create');
    // Update
    Route::patch('/{module}', [ModuleManagementController::class, 'update'])->name('api.modules.update');
    // Delete
    Route::delete('/{module}', [ModuleManagementController::class, 'delete'])->name('api.modules.delete');
    // Read
    Route::get('/{module}', [ModuleManagementController::class, 'read'])->name('api.modules.read');
    // List
    Route::get('/', [ModuleManagementController::class, 'index'])->name('api.modules.index');

    Route::prefix('api/modules/{module}')->group(function () {

        //Submissions
        //Create
        Route::post('api/assignments/{assignment}/submissions/create', [SubmissionsController::class, 'create'])->name('api.submissions.create');
        //Update
        Route::patch('/assignments/{assignment}/submissions/{submission}', [SubmissionsController::class, 'update'])->name('api.submissions.update');
        //Delete
        Route::delete('/assignments/{assignment}/submissions/{submission}', [SubmissionsController::class, 'delete'])->name('api.submissions.delete');
        //Read
        Route::get('/assignments/{assignment}/submissions/{submission}', [SubmissionsController::class, 'read'])->name('api.submissions.read');

        //Assignments
        //Create
        Route::post('/assignments/create', [AssignmentsController::class, 'create'])->name('api.assignments.create');
        //Update
        Route::patch('/assignments/{assignment}', [AssignmentsController::class, 'update'])->name('api.assignments.update');
        //Delete
        Route::delete('/assignments/{assignment}', [AssignmentsController::class, 'delete'])->name('api.assignments.delete');
        //Read
        Route::get('/assignments/{assignment}', [AssignmentsController::class, 'read'])->name('api.assignments.read');

        //Groups
        //Create
        Route::post('/assignments/{assignment}/groups/create', [GroupController::class, 'create'])->name('api.groups.create');
        //Update
        Route::patch('/assignments/{assignment}/groups/{group}', [GroupController::class, 'update'])->name('api.groups.update');
        //Delete
        Route::delete('/assignments/{assignment}/groups/{group}', [GroupController::class, 'delete'])->name('api.groups.delete');
        //Read
        Route::get('/assignments/{assignment}/groups/{group}', [GroupController::class, 'read'])->name('api.groups.read');

        //Comment
        //Create
        Route::post('/assignments/{assignment}/submissions/{submission}/comment/create', [CommentController::class, 'create'])->name('api.comments.create');
        //Update
        Route::patch('/assignments/{assignment}/submissions/{submission}/comments/{comment}', [CommentController::class, 'update'])->name('api.comments.update');
        //Delete
        Route::delete('/assignments/{assignment}/submissions/{submission}/comments/{comment}', [CommentController::class, 'delete'])->name('api.comments.delete');
        //Read

        //Notification
        //Create
        Route::post('/notifications/create', [NotificationController::class, 'create'])->name('api.notification.create');
        //Update
        Route::patch('/notifications/{notification}', [NotificationController::class, 'update'])->name('api.notification.update');
        //Delete
        Route::delete('/notifications/{notification}', [NotificationController::class, 'delete'])->name('api.notification.delete');
        //Read
        Route::get('/notifications/{notification}', [NotificationController::class, 'read'])->name('api.notification.read');
        //Read Notification
        Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('api.notification.markAsRead');
        });


    });


    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
