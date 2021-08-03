<?php

namespace App\Containers\Robots\Http\Controllers;

use App\Containers\Settings\Domain\Entities\Settings;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Http\Response;

class RobotsController extends WebController
{
    public function index(): Response
    {
        $setting = Settings::whereSlug(Settings::ROBOTS_SLUG)->first();

        return response($setting->fields->robots ?? '')
            ->header('Content-Type', 'text/plain');
    }
}
