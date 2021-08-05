<?php

namespace App\Ship\Parents\Providers;

use App\Ship\Apiato\Abstracts\Providers\AuthProvider as AbstractAuthProvider;

class AuthProvider extends AbstractAuthProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
