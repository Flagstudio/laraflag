<?php

namespace App\Http\Controllers;

use App\Settings;

class RobotsController extends Controller
{
    public function index()
    {
        $setting = Settings::whereSlug(Settings::ROBOTS_SLUG)->first();

        return response($setting->fields->robots ?? '')
            ->header('Content-Type', 'text/plain');
    }
}
