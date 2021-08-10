<?php

namespace App\Containers\Authentication\Tests\Unit;

use App\Containers\User\Domain\Entities\User;
use App\Ship\Parents\Tests\PhpUnit\TestCase;
use Illuminate\Support\Facades\Auth;

class AuthTest extends TestCase
{
    const PHONE = '+79995647977';
    const CODE = '1234';
    const WRONG_CODE = '4321';

    public function test_user_can_login()
    {
        $request = $this->createUserAndBuildRequest(self::CODE);

        $this->assertDatabaseHas('users', $request);

        $this->ajaxPost(route('auth.login'), $request)
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'data' => [
                    'accessToken',
                    'expires_in',
                ],
            ]);

        $this->assertAuthenticated();
    }

    public function test_user_send_wrong_code_for_login()
    {
        $request = $this->createUserAndBuildRequest(self::WRONG_CODE);

        $this->ajaxPost(route('auth.login'), $request)
            ->assertUnauthorized()
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    public function test_user_can_not_login_with_invalid_request()
    {
        $cases = [
            [
                'request' => [
                    'phone' => '',
                    'verify_code' => '',
                ],
                'error' => 'phone',
            ]
        ];

        //TODO asserts for all cases
    }

    public function test_user_can_logout()
    {
        Auth::login(User::first());

        $this->ajaxPost(route('auth.logout'))
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'data' => [
                    'message',
                ],
            ]);
    }

    public function test_user_can_refresh_token()
    {
        Auth::login(User::first());

        $this->ajaxPost(route('auth.refresh'))
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'data' => [
                    'accessToken',
                    'expires_in',
                ],
            ]);
    }

    public function createUserAndBuildRequest(string $verifyCode): array
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
