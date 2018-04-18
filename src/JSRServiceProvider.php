<?php

namespace Support\RemoteAuth;

use Illuminate\Support\ServiceProvider;
use App;
use Support\RemoteAuth\JSRAuth;

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


         $this->app->singleton('JSRAuth.interface', 'remote.auth');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->authRegister();
        $this->authManager();
    }


    protected function authRegister()
    {
        $this->app->singleton('remote.auth',function($app){

              return new JSRAuth(
                    $app['remote.provider.auth']
                );
        });

        $this->app->singleton('remote.provider.auth','Support\RemoteAuth\auth\IlluminateAuthAdapter');
    }

     protected function authManager()
    {
        $this->app->singleton('Support\RemoteAuth\auth\AuthInterface','remote.provider.auth');
    }


}
