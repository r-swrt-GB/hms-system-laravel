<?php

namespace App\Providers;

use App\Http\Middleware\ApiLogMiddleware;
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
        Route::middlewareGroup('admin', [
            CheckRole::class . ':admin',
            CheckRight::class . ':admin-access',
        ]);

        Route::middlewareGroup('student', [
            CheckRole::class . ':student',
            CheckRight::class . ':upload-videos',
        ]);

        Route::middlewareGroup('lecturer', [
            CheckRole::class . ':lecturer',
            CheckRight::class . ':provide-feedback',
            CheckRight::class . ':assign-marks',
            CheckRight::class . ':create-assignments',
            CheckRight::class . ':view-videos',
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
