<?php

namespace App\Providers;
use App\Services\FormValidatorService;
use Illuminate\Support\ServiceProvider;

class FormValidatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(FormValidatorServiceProvider::class,function($app){
            return new FormValidatorService();
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
