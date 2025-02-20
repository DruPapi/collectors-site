<?php

namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(!app()->isProduction());
        Auth::provider('md5pass', function (Application $app) {
            return $app->make(
                UserServiceProvider::class,
                ['model' => config('auth.providers.md5users.model')]
            );
        });
    }
}
