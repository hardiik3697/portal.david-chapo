<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfNotAuthenticated;
use App\Http\Middleware\PreventBackHistory;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(Router $router)
    {
        // Register middleware aliases
        $router->aliasMiddleware('auth', class: Authenticate::class);
        $router->aliasMiddleware('guest', class: RedirectIfNotAuthenticated::class);
        $router->aliasMiddleware('prevent-back-history', PreventBackHistory::class);
    }
}
