<?php

namespace App\Containers\User\Tests\Unit;

use App\Containers\User\Domain\Entities\User;
use App\Ship\Parents\Tests\PhpUnit\TestCase;
use Illuminate\Support\Facades\Auth;

class UserTest extends TestCase
{
    const USER_NAME = 'testUser';

    public function test_user_update()
    {
        Auth::login(User::find(1));

        $request = [
            'name' => self::USER_NAME,
        ];

        $this->postJson(route('user.update'), $request)
            ->assertOk();

        $this->assertEquals(self::USER_NAME, Auth::user()->name);
    }
}
