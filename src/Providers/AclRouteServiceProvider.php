<?php

namespace ConfrariaWeb\Acl\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class AclRouteServiceProvider extends ServiceProvider
{

    public function boot(): void
    {

        $this->routes(function () {
            Route::middleware(['api', 'auth:sanctum'])
                ->prefix('api')
                ->name('api.')
                ->group(__DIR__ . '/../Routes/api.php');

            Route::middleware(['web', 'auth:sanctum'])
                ->group(__DIR__ . '/../Routes/web.php');
        });
    }

}
