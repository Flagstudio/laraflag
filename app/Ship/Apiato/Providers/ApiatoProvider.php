<?php

namespace App\Ship\Apiato\Providers;

use App\Ship\Apiato\Abstracts\Providers\MainProvider as AbstractMainProvider;
use App\Ship\Nova\Providers\NovaServiceProvider;
use App\Ship\Providers\TelescopeServiceProvider;
use Carbon\Carbon;
use Tymon\JWTAuth\Providers\LaravelServiceProvider;

class ApiatoProvider extends AbstractMainProvider
{
    /**
     * Register any Service Providers on the Ship layer (including third party packages).
     *
     * @var array
     */
    public $serviceProviders = [
        RouteServiceProvider::class,
        ContainersServiceProvider::class,
        LaravelServiceProvider::class,
        NovaServiceProvider::class,
    ];


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Carbon::setLocale(config('app.locale'));

        if (app()->environment('production')) {
            error_reporting(E_ALL ^ E_NOTICE);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        if ($this->app->isLocal() || mb_strtolower(app()->environment()) === 'dev') {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }
}
