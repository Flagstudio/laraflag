<?php

namespace App\Ship\Apiato\Providers;

use App\Ship\Apiato\Abstracts\Providers\MainProvider as AbstractMainProvider;
use App\Ship\Providers\TelescopeServiceProvider;
use Carbon\Carbon;

/**
 * Class ApiatoProviders
 *
 * Does not have to extend from the Ship parent MainProvider since it's on the Core
 * it directly extends from the Abstract MainProvider.
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
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
