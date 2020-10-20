<?php

namespace App\Http\Controllers;

use App\Models\Settings;

class RobotsController extends Controller
{
    public function __invoke()
    {
        $setting = Settings::whereSlug(Settings::ROBOTS_SLUG)->first();

        return response($setting->fields->robots ?? '')
            ->header('Content-Type', 'text/plain');
    }
}
