<?php

namespace App\Ship\Apiato\Abstracts\Entities;

use App\Ship\Apiato\Abstracts\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as LaravelAuthenticatableUser;

/**
 * Class UserModel.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
abstract class UserEntity extends LaravelAuthenticatableUser
{
    use HasFactory;
}
