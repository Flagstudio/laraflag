<?php

namespace App\Ship\Apiato\Loaders;

use App\Ship\Apiato\Abstracts\Loaders\Loader;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class RoutesLoader extends Loader
{
    /**
     * Register all the containers routes files in the framework
     *
     * @param mixed $containerPath
     */
    public function load($containerPath)
    {
        $this->loadApiContainerRoutes($containerPath);
        $this->loadWebContainerRoutes($containerPath);
    }

    /**
     * Register the Containers API routes files
     *
     * @param $containerPath
     * @param $containersNamespace
     */
    public function loadApiContainerRoutes($containerPath)
    {
        // build the container api routes path
        $apiRoutesPath = $containerPath . '/Routes';
        $apiRoutesFile = $apiRoutesPath . '/api.php';
        // build the namespace from the path
        $controllerNamespace = 'App\\Containers\\' . basename($containerPath) . '\\Controllers';

        if (File::isDirectory($apiRoutesPath) && File::exists($apiRoutesFile)) {
            Route::middleware('api')
                ->namespace($controllerNamespace)
                ->group($apiRoutesFile);
        }
    }

    /**
     * Register the Containers WEB routes files
     *
     * @param $containerPath
     * @param $containersNamespace
     */
    public function loadWebContainerRoutes($containerPath)
    {
        // build the container web routes path
        $webRoutesPath = $containerPath . '/Routes';
        $webRoutesFile = $webRoutesPath . '/web.php';
        // build the namespace from the path
        $controllerNamespace = 'App\\Containers\\' . basename($containerPath) . '\\Controllers';

        if (File::isDirectory($webRoutesPath) && File::exists($webRoutesFile)) {
            Route::middleware('web')
                ->namespace($controllerNamespace)
                ->group($webRoutesFile);
        }
    }
}
