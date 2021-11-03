<?php

return [
    'icon' => '/vendor/nova-admin-bar/logo.svg',

    'dropdown_links' => [
        'Laravel Docs' => 'https://laravel.com/docs/master/eloquent-collections',
        'Nova Docs' => 'https://nova.laravel.com/docs/2.0/resources/fields.html',
        'Flagstudio' => 'https://flagstudio.ru',
    ],

    'links' => [
        'Admin panel' => '/_admin',
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Bar position
    |--------------------------------------------------------------------------
    |
    | Supported: "top", "bottom"
    |
    */
    'position' => 'top',

    'commit' => env('GIT_COMMIT', ''),
    'branch' => env('GIT_BRANCH', ''),
    'date' => env('GIT_DATE', ''),

    //Namespace to nova resources
    'resources_namespace' => '\\App\\Nova\\',
];
