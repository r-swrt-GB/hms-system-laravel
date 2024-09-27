<?php

namespace App\Providers;

use App\Http\Middleware\ApiLogMiddleware;
use App\Http\Middleware\ModuleAccessMiddleware;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckRight;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Route::middlewareGroup('moduleAccess', [
            ModuleAccessMiddleware::class . ':moduleAccess',
        ]);

        Route::middlewareGroup('admin', [
            CheckRole::class . ':admin',
            CheckRight::class . ':admin-access',
        ]);

        Route::middlewareGroup('lecturer', [
            CheckRole::class . ':lecturer',
            CheckRight::class . ':lecturer-access',

            CheckRight::class . ':module-list-view-access',
            CheckRight::class . ':module-view-access',
            CheckRight::class . ':module-create-access',
            CheckRight::class . ':module-update-access',
            CheckRight::class . ':module-delete-access',

            CheckRight::class . ':notification-view-access',
            CheckRight::class . ':notification-create-access',
            CheckRight::class . ':notification-update-access',
            CheckRight::class . ':notification-update-access',
            CheckRight::class . ':notification-delete-access',

            CheckRight::class . ':submission-view-access',
            CheckRight::class . ':submission-create-access',
            CheckRight::class . ':submission-update-access',
            CheckRight::class . ':submission-delete-access',

            CheckRight::class . ':assignment-view-access',
            CheckRight::class . ':assignment-create-access',
            CheckRight::class . ':assignment-mark-as-read-update-update-access',
            CheckRight::class . ':assignment-delete-access',

            CheckRight::class . ':comment-view-access',
            CheckRight::class . ':comment-create-access',
            CheckRight::class . ':comment-update-access',
            CheckRight::class . ':comment-delete-access',

            CheckRight::class . ':profile-view-access',
            CheckRight::class . ':profile-update-access',
            CheckRight::class . ':profile-delete-access',
        ]);

        Route::middlewareGroup('student', [
            CheckRole::class . ':student',
            CheckRight::class . ':student-access',

            CheckRight::class . ':module-view-access',

            CheckRight::class . ':notification-view-access',
            CheckRight::class . ':notification-mark-as-read-update-access',

            CheckRight::class . ':submission-view-access',
            CheckRight::class . ':submission-create-access',
            CheckRight::class . ':submission-update-access',

            CheckRight::class . ':comment-view-list-access',
            CheckRight::class . ':comment-view-access',

            CheckRight::class . ':assignment-view-access',

            CheckRight::class . ':comment-view-access',

            CheckRight::class . ':profile-view-access',
            CheckRight::class . ':profile-update-access',
            CheckRight::class . ':profile-delete-access',
        ]);

        Route::middlewareGroup('apiLog', [
            ApiLogMiddleware::class . ':apiLog',
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
