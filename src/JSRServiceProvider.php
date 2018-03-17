<?php

namespace JSR\JSRAuth;

use Illuminate\Support\ServiceProvider;

class JSRServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/JSRAuth.php' => config_path('JSRAuth.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
