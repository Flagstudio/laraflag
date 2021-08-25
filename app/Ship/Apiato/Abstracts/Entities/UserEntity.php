<?php

namespace App\Ship\Apiato\Abstracts\Entities;

use App\Ship\Apiato\Abstracts\Factories\HasFactory;
use Baethon\LaravelCriteria\Traits\AppliesCriteria;
use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class UserEntity extends Authenticatable
{
    use HasFactory,
        AppliesCriteria;
}
