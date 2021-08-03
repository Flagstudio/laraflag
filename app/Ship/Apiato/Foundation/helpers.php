<?php

/*
 * You can define global functions in this file
 */

if (! function_exists('container_path')) {
    function container_path(string $path): string
    {
        return app_path('Containers/' . $path);
    }
}

if (! function_exists('ship_path')) {
    function ship_path(string $path): string
    {
        return app_path('Ship/' . $path);
    }
}

if (! function_exists('task')) {
    function task(...$parameters)
    {
        return resolve(\App\Ship\Apiato\Helpers\CallTask::class)
            ->task(...$parameters);
    }
}

if (! function_exists('run_action')) {
    function run_action(...$parameters)
    {
        return resolve(\App\Ship\Apiato\Helpers\CallAction::class)
            ->action(...$parameters);
    }
}
