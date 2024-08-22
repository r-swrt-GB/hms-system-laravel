<?php


namespace App\Classes\Routes;

use App\Classes\Routes\RoutesV1\ApiRoutesV1;
use App\Classes\Routes\RoutesV1\AuthRoutesV1;
use Illuminate\Support\Facades\Route;

class ApiRoutes
{
    public static function get(): void
    {
        Route::prefix('api/')->group(function () {

            Route::prefix('v1/')->group(function () {
                ApiRoutesV1::get();
                AuthRoutesV1::get();
            });
        });
    }
}
