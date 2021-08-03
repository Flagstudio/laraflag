<?php

namespace App\Ship\Parents\Providers;

use App\Ship\Apiato\Abstracts\Providers\RoutesProvider as AbstractRoutesProvider;

/**
 * Class RoutesProvider.
 *
 * A.K.A app/Providers/RouteServiceProvider.php
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class RoutesProvider extends AbstractRoutesProvider
{

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        parent::boot();
    }
}
