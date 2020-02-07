<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    const METRICS_SLUG = 'metrics';
    const ROBOTS_SLUG = 'robots';

    protected $casts = [
        'fields' => 'object',
    ];
}
