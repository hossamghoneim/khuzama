<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // change public to public
        $this->app->bind('path.public', function() {
            return base_path('public');
        });

        //
        include_once app_path().'/Http/Helpers.php';

    }
}
