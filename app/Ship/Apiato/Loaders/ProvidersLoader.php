<?php

namespace App\Ship\Apiato\Loaders;

use App\Ship\Apiato\Abstracts\Loaders\Loader;
use App\Ship\Apiato\Foundation\Facades\Apiato;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class ProvidersLoader extends Loader
{
    public function load($containerPath)
    {
        $providersPath = "$containerPath/Providers/";

        if (File::isDirectory($providersPath)) {
            $providers = File::allFiles($providersPath);

            foreach ($providers as $provider) {
                if (File::isFile($provider)) {
                    $providerClass = Apiato::getClassFullNameFromFile($provider->getPathname());
                    App::register($providerClass);
                }
            }
        }
    }
}
