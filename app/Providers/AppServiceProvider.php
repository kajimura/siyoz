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
        //
        $this->app->singleton('App\Services\Apl', function ($app) {
            return new \App\Services\Apl();
        });
        $this->app->bind('App\Services\Message', function ($app) {
            return new \App\Services\Message();
        });
        $this->app->bind('App\Services\Meet', function ($app) {
            return new \App\Services\Meet();
        });
        $this->app->bind('App\Services\Appointment', function ($app) {
            return new \App\Services\Appointment();
        });
        $this->app->bind('App\Services\Match', function ($app) {
            return new \App\Services\Match();
        });
        $this->app->bind('App\Services\Logic\MakeSitemapXml', function ($app) {
            return new \App\Services\Logic\MakeSitemapXml();
        });
        $this->app->bind('App\Services\Logic\OnamaeDomainMod', function ($app) {
            return new \App\Services\Logic\OnamaeDomainMod();
        });
        $this->app->bind('App\Services\OnamaeClient', function ($app) {
            return new \App\Services\OnamaeClient();
        });
        $this->app->bind('App\Services\OnamaeParam', function ($app) {
            return new \App\Services\OnamaeParam();
        });
        $this->app->bind('App\Services\EmailSend', function ($app) {
            return new \App\Services\EmailSend();
        });
        $this->app->bind('App\User', function ($app) {
            return new \App\User();
        });
        $this->app->bind('Kz_Core', function ($app) {
            return new \Kz_Core();
        });
        $this->app->bind('Kz_GoogleMapModel', function ($app) {
            return new \Kz_GoogleMapModel();
        });
    }
}
