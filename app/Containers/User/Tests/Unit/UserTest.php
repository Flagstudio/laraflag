<?php

namespace App\Containers\User\Tests\Unit;

use App\Ship\Parents\Tests\PhpUnit\TestCase;

class UserTest extends TestCase
{
    const USER_NAME = 'testUser';
    const USER_PHONE = '+79636550055';
    const USER_EMAIL = 'test@test.test';

    public function test_user_update(): void
    {
        $request = [
            'name' => self::USER_NAME,
            'phone' => self::USER_PHONE,
            'email' => self::USER_EMAIL,
            'birthday' => now()->format('d.m.Y'),
            'offers' => true,
        ];

        $this->asAuthenticated()
            ->postJson(route('users.update'), $request)
            ->assertOk();

        $this->assertDatabaseHas('users', [
            'name' => self::USER_NAME,
            'phone' => self::USER_PHONE,
            'email' => self::USER_EMAIL,
        ]);
    }

    public function test_validation_rules_for_update()
    {
        $cases = [
            [
                'request' => ['name' => ''],
                'errors' => ['name'],
                'success' => [],
            ],
            [
                'request' => ['name' => self::USER_NAME],
                'errors' => [],
                'success' => ['name'],
            ],
            [
                'request' => ['name' => '', 'phone' => '', 'email' => '', 'birthday' => '', 'offers' => ''],
                'errors' => ['name'],
                'success' => [],
            ],
            [
                'request' => ['name' => self::USER_NAME, 'phone' => '', 'email' => '', 'birthday' => '', 'offers' => ''],
                'errors' => [],
                'success' => ['name'],
            ],
            [
                'request' => ['name' => self::USER_NAME, 'phone' => 'fbga', 'email' => '', 'birthday' => '', 'offers' => ''],
                'errors' => ['phone'],
                'success' => ['name'],
            ],
            [
                'request' => ['name' => self::USER_NAME, 'phone' => 'fbga', 'email' => 'grt54-+*-', 'birthday' => '', 'offers' => ''],
                'errors' => ['phone', 'email'],
                'success' => ['name'],
            ],
            [
                'request' => ['name' => '2', 'phone' => 'fbga', 'email' => 'grt54-+*-', 'birthday' => '', 'offers' => ''],
                'errors' => ['name', 'phone', 'email'],
                'success' => [],
            ],
            [
                'request' => ['name' => self::USER_NAME, 'phone' => self::USER_PHONE, 'email' => self::USER_EMAIL],
                'errors' => [],
                'success' => ['name', 'phone', 'email'],
            ],
        ];

        $this->testingValidationCases($cases, route('users.update'), $this->userToken);
    }

    public function test_get_user_info(): void
    {
        $this->asAuthenticated()
            ->getJson(route('users.show'))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'phone',
                    'email',
                ],
            ]);
    }
}
