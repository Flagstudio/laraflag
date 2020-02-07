<?php

use App\Settings;
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
        if (!Settings::whereSlug($metricsSlug)->exists()) {
            factory('App\Settings')->create([
                'title' => 'Метрики',
                'slug' => $metricsSlug,
                'fields' => [],
            ]);
        }
    }
}
