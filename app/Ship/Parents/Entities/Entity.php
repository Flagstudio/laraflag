<?php

namespace App\Ship\Parents\Entities;

use App\Ship\Apiato\Abstracts\Entities\Entity as AbstractEntity;

abstract class Entity extends AbstractEntity
{
    protected $guarded = [];
}
