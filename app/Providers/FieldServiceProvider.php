<?php

namespace App\Providers;

use App\Services\FieldService;
use Illuminate\Support\ServiceProvider;

final class FieldServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->singleton('fieldService', function ($app) {
            return new FieldService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}