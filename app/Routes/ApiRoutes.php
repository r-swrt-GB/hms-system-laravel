<?php


namespace App\Routes;

use App\Http\Middleware\ApiLogMiddleware;
use App\Routes\RoutesV1\ApiRoutesV1;
use App\Routes\RoutesV1\AuthRoutesV1;
use Illuminate\Support\Facades\Route;

class ApiRoutes
{
    public static function get(): void
    {
        Route::middleware(['apiLog', 'api-session'])->group(function () {

            Route::prefix('v1/')->group(function () {
                ApiRoutesV1::get();

                Route::middleware('throttle:10,1')->group(function () {
                    AuthRoutesV1::get();
                });
            });

        });
    }
}
