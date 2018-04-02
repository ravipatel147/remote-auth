<?php

namespace Support\RemoteAuth;

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
            __DIR__.'/config/RemoteAuth.php' => config_path('RemoteAuth.php'),
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
