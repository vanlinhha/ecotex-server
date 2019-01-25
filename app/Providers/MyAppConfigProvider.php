<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MyAppConfigProvider extends ServiceProvider {

    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        //register menu config
        $this->app->singleton('MenuLeftConfig', function($app) {
            return new \App\Libs\Config\MenuLeftConfig();
        });

        //register menu config
        $this->app->singleton('PermitConfig', function($app) {
            return new \App\Libs\Config\PermitConfig();
        });
        //register type xhh config
        $this->app->singleton('TypeXHHConfig', function($app) {
            return new \App\Libs\Config\TypeXHHConfig();
        });

    }

    public function provides() {
        return [
            'MenuLeftConfig',
            'PermitConfig',
            'TypeXHHConfig',
        ];
    }

}
