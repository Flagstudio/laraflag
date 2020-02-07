<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    const METRICS_SLUG = 'metrics';

    protected $casts = [
        'fields' => 'object',
    ];
}
