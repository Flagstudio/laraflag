<?php

namespace App\Containers\Authentication\Tests\Unit;

use App\Containers\User\Domain\Entities\User;
use App\Ship\Parents\Tests\PhpUnit\TestCase;

class RegisterTest extends TestCase
{
    const PHONE = '+79995647977';

    public function test_user_can_register()
    {
        $request = [
            'phone' => self::PHONE,
        ];

        $this->assertDatabaseMissing('users', $request);

        $this->ajaxPost(route('auth.register'), $request)
            ->assertCreated();
    }

    public function test_user_can_login()
    {
        $existingUser = User::first();
        $request = [
            'phone' => $existingUser->phone,
        ];

        $this->assertDatabaseHas('users', $request);

        $this->ajaxPost(route('auth.register'), $request)
            ->assertOk();
    }
}
