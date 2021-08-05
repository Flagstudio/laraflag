<?php

namespace App\Ship\Parents\Providers;

use App\Ship\Apiato\Abstracts\Providers\BroadcastsProvider as AbstractBroadcastsProvider;
use Illuminate\Support\Facades\Broadcast;
use function app_path;

class BroadcastsProvider extends AbstractBroadcastsProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        require app_path('Ship/Broadcasts/Routes.php');
    }
}
