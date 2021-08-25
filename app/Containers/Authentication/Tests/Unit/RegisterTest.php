<?php

namespace App\Containers\Authentication\Tests\Unit;

use App\Containers\User\Domain\Entities\User;
use App\Ship\Parents\Tests\PhpUnit\TestCase;
use Illuminate\Support\Facades\Http;

class RegisterTest extends TestCase
{
    const PHONE = '+79636550055';
    const NAME = 'empty';

    public function test_user_can_register(): void
    {
        $request = [
            'phone' => self::PHONE,
        ];

        $this->assertDatabaseMissing('users', $request);

        $this->postJson(route('auth.register'), $request)
            ->assertCreated()
            ->assertJsonStructure([
                'status',
                'data' => [
                    'is_new',
                ],
            ])
            ->assertJsonFragment(['is_new' => true]);

        $this->assertDatabaseHas('users', $request);

        //testing integration with 1C
        Http::assertSent($this->sendOneSGetUser(self::PHONE));
    }

    public function test_validation_rules_for_register()
    {
        $cases = [
            [
                'request' => ['phone' => ''],
                'errors' => ['phone'],
                'success' => [],
            ],
            [
                'request' => ['phone' => '19583'],
                'errors' => ['phone'],
                'success' => [],
            ],
            [
                'request' => ['phone' => self::PHONE],
                'errors' => [],
                'success' => ['phone'],
                'status' => 201,
            ],
            [
                'request' => ['phone' => 'qwertyuiopsd'],
                'errors' => ['phone'],
                'success' => [],
            ],
            [
                'request' => ['phone' => '+7911111111'],
                'errors' => ['phone'],
                'success' => [],
            ],
            [
                'request' => ['phone' => '+79aaabbbccdd'],
                'errors' => ['phone'],
                'success' => [],
            ],
        ];

        $this->testingValidationCases($cases, route('auth.register'));
    }

    public function test_user_can_login(): void
    {
        $existingUser = User::first();
        $request = [
            'phone' => $existingUser->phone,
        ];

        $this->assertDatabaseHas('users', $request);

        $this->postJson(route('auth.register'), $request)
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'data' => [
                    'is_new',
                ],
            ])
            ->assertJsonFragment(['is_new' => false]);

        //testing integration with 1C
        Http::assertNotSent($this->sendOneSGetUser(self::PHONE));
    }
}
