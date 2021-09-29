<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metricsSlug = Settings::METRICS_SLUG;
        if (! Settings::whereSlug($metricsSlug)->exists()) {
            Settings::factory()->create([
                'title' => 'Метрики',
                'slug' => $metricsSlug,
                'fields' => [],
            ]);
        }

        $robotsSlug = Settings::ROBOTS_SLUG;
        if (! Settings::whereSlug($robotsSlug)->exists()) {
            Settings::factory()->create([
                'title' => 'Robots.txt',
                'slug' => $robotsSlug,
                'fields' => [],
            ]);
        }
    }
}
