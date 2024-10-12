<?php

namespace App\Routes\RoutesV1;

use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ModuleManagementController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionsController;
use Illuminate\Support\Facades\Route;

class ApiRoutesV1
{
    public static function get()
    {
        // Authenticated requests
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/assignments', [AssignmentsController::class, 'getUserAssignments'])->name('api.assignments.user.list');
            Route::get('/groups', [GroupController::class, 'getUserGroups'])->name('api.groups.user.list');


            Route::prefix('/modules')->group(function () {

                Route::middleware('student')->group(function () {
                    Route::middleware('lecturer')->group(function () {
                        // Create
                        Route::post('/create', [ModuleManagementController::class, 'create'])->name('api.modules.create');
                        // List (specific route)
                        Route::get('/list', [ModuleManagementController::class, 'list'])->name('api.modules.modules.list');

                        Route::middleware('moduleAccess')->group(function () {
                            // Update
                            Route::patch('/{module}', [ModuleManagementController::class, 'update'])->name('api.modules.update');
                            // Delete
                            Route::delete('/{module}', [ModuleManagementController::class, 'delete'])->name('api.modules.delete');
                        });
                    });
                    // List (user modules)
                    Route::get('/', [ModuleManagementController::class, 'getUserModules'])->name('api.modules.list');
                    // Read
                    Route::get('/{module}', [ModuleManagementController::class, 'read'])->name('api.modules.read');
                });


                Route::middleware('moduleAccess')->group(function () {
                    // Module Specific requests
                    Route::prefix('/{module}')->group(function () {

                        //Notifications
                        Route::middleware('student')->group(function () {
                            Route::middleware('lecturer')->group(function () {
                                //Create
                                Route::post('/notifications/create', [NotificationController::class, 'create'])->name('api.notification.create');
                                //Update
                                Route::patch('/notifications/{notification}', [NotificationController::class, 'update'])->name('api.notification.update');
                                //Delete
                                Route::delete('/notifications/{notification}', [NotificationController::class, 'delete'])->name('api.notification.delete');
                            });

                            //Read
                            Route::get('/notifications/{notification}', [NotificationController::class, 'read'])->name('api.notification.read');
                            //Read Notification
                            Route::patch('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('api.notification.markAsRead');
                            //List
                            Route::get('/notifications', [NotificationController::class, 'getUserNotifications'])->name('api.notification.user.list');
                        });


                        //Submissions
                        Route::middleware('student')->group(function () {
                            Route::middleware('lecturer')->group(function () {
                                //List
                                Route::get('/assignments/{assignment}/submissions/', [SubmissionsController::class, 'getAssignmentSubmissions'])->name('api.submissions.assignment.list');
                                //Delete
                                Route::delete('/assignments/{assignment}/submissions/{submission}', [SubmissionsController::class, 'delete'])->name('api.submissions.delete');
                            });

                            //Create
                            Route::post('/assignments/{assignment}/submissions/create', [SubmissionsController::class, 'create'])->name('api.submissions.create');
                            //Read
                            Route::get('/assignments/{assignment}/submissions/{submission}', [SubmissionsController::class, 'read'])->name('api.submissions.read');
                            //Update
                            Route::patch('/assignments/{assignment}/submissions/{submission}', [SubmissionsController::class, 'update'])->name('api.submissions.update');
                        });


                        //Assignments
                        Route::middleware('student')->group(function () {
                            Route::middleware('lecturer')->group(function () {
                                //Create
                                Route::post('/assignments/', [AssignmentsController::class, 'create'])->name('api.assignments.create');
                                //Update
                                Route::patch('/assignments/{assignment}', [AssignmentsController::class, 'update'])->name('api.assignments.update');
                                //Delete
                                Route::delete('/assignments/{assignment}', [AssignmentsController::class, 'delete'])->name('api.assignments.delete');
                            });

                            //Read
                            Route::get('/assignments/{assignment}', [AssignmentsController::class, 'read'])->name('api.assignments.read');
                            //List
                            Route::get('/assignments/', [AssignmentsController::class, 'getModuleAssignments'])->name('api.assignments.module.list');
                        });

                        //Groups
                        Route::middleware('student')->group(function () {
                            Route::middleware('lecturer')->group(function () {
                                //Create
                                Route::post('/assignments/{assignment}/groups/create', [GroupController::class, 'create'])->name('api.groups.create');
                                //Update
                                Route::patch('/assignments/{assignment}/groups/{group}', [GroupController::class, 'update'])->name('api.groups.update');
                                //Delete
                                Route::delete('/assignments/{assignment}/groups/{group}', [GroupController::class, 'delete'])->name('api.groups.delete');
                                //Read List
                                Route::get('/assignments/{assignment}/groups/list', [GroupController::class, 'read'])->name('api.groups.list.read');
                            });
                            //Read
                            Route::get('/assignments/{assignment}/groups/{group}', [GroupController::class, 'read'])->name('api.groups.read');
                        });

                        //Comment
                        Route::middleware('student')->group(function () {
                            Route::middleware('lecturer')->group(function () {
                                //Create
                                Route::post('/assignments/{assignment}/submissions/{submission}/comment/create', [CommentController::class, 'create'])->name('api.comments.create');
                                //Update
                                Route::patch('/assignments/{assignment}/submissions/{submission}/comments/{comment}', [CommentController::class, 'update'])->name('api.comments.update');
                                //Delete
                                Route::delete('/assignments/{assignment}/submissions/{submission}/comments/{comment}', [CommentController::class, 'delete'])->name('api.comments.delete');
                            });
                            //List
                            Route::get('assignments/{assignment}/submissions/{submission}/comments/', [CommentController::class, 'getSubmissionComments'])->name('api.submissions.comments.list');
                        });
                    });
                });
            });

            Route::middleware('throttle:10,1')->group(function () {
                // Profile
                Route::get('/profile', [ProfileController::class, 'getUserProfile'])->name('profile.get');
                Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
                Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

                Route::post('/create/user', [RegisteredUserController::class, 'createPendingUser'])->name('api.users.pending.create');
                Route::patch('/edit/user/{user}', [RegisteredUserController::class, 'editUser'])->name('api.users.update');
                Route::delete('/delete/user/{user}', [RegisteredUserController::class, 'deleteUser'])->name('api.users.delete');
            });
        });
    }
}

