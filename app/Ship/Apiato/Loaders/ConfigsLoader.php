<?php

namespace App\Ship\Apiato\Loaders;

use App\Ship\Apiato\Abstracts\Loaders\Loader;
use Illuminate\Support\Facades\File;

class ConfigsLoader extends Loader
{
    /**
     * @param $containerName
     * @param mixed $containerPath
     */
    public function load($containerPath)
    {
        $directory = "$containerPath/Configs/";

        if (File::isDirectory($directory)) {
            $files = File::allFiles($directory);

            foreach ($files as $file) {
                $fileNameOnly = str_replace('.php', '', $file->getFilename());

                $this->mergeConfigFrom($file->getPathname(), $fileNameOnly);
            }
        }
    }
}
