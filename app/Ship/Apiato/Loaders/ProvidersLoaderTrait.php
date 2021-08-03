<?php

namespace App\Ship\Apiato\Loaders;

use App\Ship\Apiato\Foundation\Facades\Apiato;
use App;
use Illuminate\Support\Facades\File;

trait ProvidersLoaderTrait
{
    protected $serviceProviders = [];

    public function loadOnlyMainProvidersFromContainers(string $containerName): void
    {
        $containerProvidersDirectory = base_path('app/Containers/' . $containerName . '/Providers');

        $this->loadProviders($containerProvidersDirectory);
    }

    private function loadProviders(string $directory): void
    {
        $mainServiceProviderNameStartWith = 'Main';

        if (File::isDirectory($directory)) {
            $files = File::allFiles($directory);

            foreach ($files as $file) {
                if (File::isFile($file)) {

                    // Check if this is the Main Service Provider
                    if (Apiato::stringStartsWith($file->getFilename(), $mainServiceProviderNameStartWith)) {
                        $serviceProviderClass = Apiato::getClassFullNameFromFile($file->getPathname());

                        $this->loadProvider($serviceProviderClass);
                    }
                }
            }
        }
    }

    /**
     * @param $providerFullName
     */
    private function loadProvider($providerFullName): void
    {
        App::register($providerFullName);
    }

    public function loadServiceProviders(): void
    {
        foreach ($this->serviceProviders as $provider) {
            $this->loadProvider($provider);
        }
    }
}
