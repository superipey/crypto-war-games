<?php
namespace App\Libraries; 

use Illuminate\Support\ServiceProvider;

class HashServiceProvider extends ServiceProvider
{
    protected $defer = true;
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('hash', function () {
            return new PlainHasher;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['hash'];
    }
}
