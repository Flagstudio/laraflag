<?php

namespace App\Ship\Apiato\Providers;

use App\Ship\Apiato\Foundation\Facades\Apiato;
use App\Ship\Apiato\Loaders\ConfigsLoader;
use App\Ship\Apiato\Loaders\MigrationsLoader;
use App\Ship\Apiato\Loaders\ProvidersLoader;
use App\Ship\Apiato\Loaders\RoutesLoader;
use Illuminate\Support\ServiceProvider;

class ContainersServiceProvider extends ServiceProvider
{
    public array $loaders = [];

    public function __construct($app)
    {
        parent::__construct($app);

        $this->loaders = [
            new RoutesLoader,
            new MigrationsLoader,
            new ProvidersLoader,
            new ConfigsLoader,
        ];
    }

    /**
     * Bootstrap all porto containers.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $containersPaths = Apiato::getContainersPaths();
        foreach ($containersPaths as $containerPath) {
            foreach ($this->loaders as $loader) {
                $loader->load($containerPath);
            }
        }
    }
}
