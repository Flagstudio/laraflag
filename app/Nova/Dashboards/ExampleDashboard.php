<?php

namespace App\Nova\Dashboards;

use Flagstudio\CustomCard\CustomCard;
use Laravel\Nova\Dashboard;

class ExampleDashboard extends Dashboard
{
    /**
     * @return string
     */
    public static function label()
    {
        return 'Пример Дашборда';
    }

    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        $totals_1 = view('nova.example_dashboard')->render();

        return [
            new CustomCard($totals_1, '1/2'),
        ];
    }

    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'example-dashboard';
    }
}
