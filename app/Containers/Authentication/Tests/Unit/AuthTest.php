<?php

namespace App\Containers\Authentication\Tests\Unit;

use App\Containers\User\Domain\Entities\User;
use App\Ship\Parents\Tests\PhpUnit\TestCase;

class AuthTest extends TestCase
{
    const PHONE = '+79636550055';
    const CODE = '1234';
    const WRONG_CODE = '4321';

    public function test_user_can_login(): void
    {
        $request = $this->createUserAndBuildRequest(self::CODE);

        $this->assertDatabaseHas('users', $request);

        $this->postJson(route('auth.login'), $request)
            ->assertOk()
            ->assertJsonStructure(self::JSON_TOKEN_STRUCTURE);
    }

    public function test_validation_rules_for_login()
    {
        $this->assertGuest();

        $cases = [
            [
                'request' => ['phone' => '', 'verify_code' => ''],
                'errors' => ['phone', 'verify_code'],
                'success' => [],
            ],
            [
                'request' => ['phone' => '19583', 'verify_code' => ''],
                'errors' => ['phone', 'verify_code'],
                'success' => [],
            ],
            [
                'request' => ['phone' => '19583', 'verify_code' => '00000'],
                'errors' => ['phone', 'verify_code'],
                'success' => [],
            ],
            [
                'request' => ['phone' => '19583', 'verify_code' => '0000'],
                'errors' => ['phone'],
                'success' => ['verify_code'],
            ],
            [
                'request' => ['phone' => self::PHONE, 'verify_code' => '+fhr'],
                'errors' => ['verify_code'],
                'success' => ['phone'],
            ],
            [
                'request' => ['phone' => '+7555', 'verify_code' => self::CODE],
                'errors' => ['phone'],
                'success' => ['verify_code'],
            ],
            [
                'request' => ['phone' => '+75555555555', 'verify_code' => '000a'],
                'errors' => ['phone', 'verify_code'],
                'success' => [],
            ],
            [
                'request' => ['phone' => self::PHONE, 'verify_code' => self::CODE],
                'errors' => [],
                'success' => ['phone', 'verify_code'],
            ],
        ];

        User::factory()->create([
            'phone' => self::PHONE,
            'verify_code' => self::CODE,
        ]);

        $this->testingValidationCases($cases, route('auth.login'));
    }

    public function test_user_can_login_with_testing_code(): void
    {
        $request = $this->createUserAndBuildRequest(self::CODE);

        $this->assertDatabaseHas('users', $request);

        $request['verify_code'] = '0000';

        $this->postJson(route('auth.login'), $request)
            ->assertOk()
            ->assertJsonStructure(self::JSON_TOKEN_STRUCTURE);
    }

    public function test_user_send_wrong_code_for_login(): void
    {
        $request = $this->createUserAndBuildRequest(self::WRONG_CODE);

        $this->postJson(route('auth.login'), $request)
            ->assertUnauthorized()
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    public function test_user_can_logout(): void
    {
        $this->asAuthenticated()
            ->postJson(route('auth.logout'))
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'data' => [
                    'message',
                ],
            ]);
    }

    public function test_user_can_refresh_token(): void
    {
        $this->asAuthenticated()
            ->postJson(route('auth.refresh'))
            ->assertOk()
            ->assertJsonStructure(self::JSON_TOKEN_STRUCTURE);
    }

    private function createUserAndBuildRequest(string $verifyCode): array
    {
        $user = User::factory()->create([
            'verify_code' => self::CODE,
        ]);

        return [
            'phone' => $user->phone,
            'verify_code' => $verifyCode,
        ];
    }
}
