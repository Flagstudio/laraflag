<?php

namespace App\Containers\Settings\Domain\Entities;

use App\Ship\Apiato\Abstracts\Factories\HasFactory;
use App\Ship\Parents\Entities\Entity;

class Settings extends Entity
{
    use HasFactory;

    const METRICS_SLUG = 'metrics';
    const ROBOTS_SLUG = 'robots';

    protected $casts = [
        'fields' => 'object',
    ];
}
