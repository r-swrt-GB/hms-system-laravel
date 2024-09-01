<?php


namespace App\Routes;

use App\Routes\RoutesV1\ApiRoutesV1;
use App\Routes\RoutesV1\AuthRoutesV1;
use Illuminate\Support\Facades\Route;

class ApiRoutes
{
    public static function get(): void
    {
        Route::prefix('v1/')->group(function () {
            ApiRoutesV1::get();
            AuthRoutesV1::get();
        });
    }
}
