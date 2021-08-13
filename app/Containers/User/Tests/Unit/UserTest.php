<?php

namespace App\Containers\User\Tests\Unit;

use App\Containers\User\Domain\Entities\User;
use App\Ship\Parents\Tests\PhpUnit\TestCase;
use Illuminate\Support\Facades\Auth;

class UserTest extends TestCase
{
    const USER_NAME = 'testUser';
    const USER_PHONE = '+79995647977';
    const USER_EMAIL = 'test@test.test';

    public function setUp(): void
    {
        parent::setUp();

        Auth::login(User::first());
    }

    public function test_user_update(): void
    {
        $request = [
            'name' => self::USER_NAME,
            'phone' => self::USER_PHONE,
            'email' => self::USER_EMAIL,
            'birthday' => now()->format('d.m.Y'),
            'offers' => true,
        ];

        $this->postJson(route('user.update'), $request)
            ->assertOk();

        $this->assertEquals(self::USER_NAME, Auth::user()->name);
        $this->assertEquals(self::USER_PHONE, Auth::user()->phone);
        $this->assertEquals(self::USER_EMAIL, Auth::user()->email);
    }

    public function test_get_user_info(): void
    {
        $this->getJson(route('user.show'))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    [
                        'name',
                        'phone',
                        'email',
                    ],
                ],
            ]);
    }
}
