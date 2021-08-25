<?php

namespace App\Ship\Apiato\Abstracts\Entities;

use App\Ship\Apiato\Abstracts\Factories\HasFactory;
use Baethon\LaravelCriteria\Traits\AppliesCriteria;
use Illuminate\Database\Eloquent\Model;

abstract class Entity extends Model
{
    use HasFactory,
        AppliesCriteria;
}