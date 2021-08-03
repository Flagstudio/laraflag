<?php

namespace App\Ship\Apiato\Loaders;

use App\Ship\Apiato\Abstracts\Loaders\Loader;
use Illuminate\Support\Facades\File;

class MigrationsLoader extends Loader
{
    public function load($containerPath)
    {
        $migrationsPath = "$containerPath/Domain/Migrations/";

        if (File::isDirectory($migrationsPath)) {
            $this->loadMigrationsFrom($migrationsPath);
        }
    }
}
