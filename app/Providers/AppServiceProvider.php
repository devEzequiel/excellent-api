<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            'App\Domains\Order\Contracts\OrderRepositoryInterface',
            'App\Domains\Order\Repositories\OrderRepository'
        );

        $this->app->bind(
            'App\Domains\Product\Contracts\ProductRepositoryInterface',
            'App\Domains\Product\Repositories\ProductRepository'
        );

        $this->app->bind(
            'App\Domains\Client\Contracts\ClientRepositoryInterface',
            'App\Domains\Client\Repositories\ClientRepository'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
