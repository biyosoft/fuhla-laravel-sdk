<?php

namespace Biyosoft\FuhlaLaravelSdk;

use Biyosoft\FuhlaLaravelSdk\Library\Fuhla;

use Illuminate\Support\ServiceProvider;

class FuhlaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('FUHLA', function ($app) {
            return new Fuhla(["id" => env('FUHLA_USER_TOKEN'), "url" => env('FUHLA_LIVE')]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $fuhla = new Fuhla(["id" => env('FUHLA_USER_TOKEN'), "url" => env('FUHLA_LIVE')]);
        $fuhla->get_fuhla_data();
    }
}
