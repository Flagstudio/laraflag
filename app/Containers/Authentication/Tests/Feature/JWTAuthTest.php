<?php

namespace App\Containers\Authentication\Tests\Feature;

use App\Containers\User\Domain\Entities\User;
use App\Ship\Parents\Tests\PhpUnit\TestCase;

class JWTAuthTest extends TestCase
{
    const PHONE = '+79636550055';
    const CODE = '1234';

    public function test_user_can_work_like_authenticated_with_jwt_auth()
    {
        $user = User::factory()->create([
            'verify_code' => self::CODE,
        ]);

        $request = [
            'phone' => $user->phone,
            'verify_code' => self::CODE,
        ];

        $this->assertDatabaseHas('users', $request);

        //user authentication
        $responseLogin = $this->postJson(route('auth.login'), $request)
            ->assertOk()
            ->assertJsonStructure(self::JSON_TOKEN_STRUCTURE);

        $token = $responseLogin->getOriginalContent()['data']['accessToken'];

        //refresh JWT
        $responseRefresh = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson(route('auth.refresh'))
            ->assertOk()
            ->assertJsonStructure(self::JSON_TOKEN_STRUCTURE);

        $refreshToken = $responseRefresh->getOriginalContent()['data']['accessToken'];

        //JWT was refreshed
        $this->assertNotEquals($token, $refreshToken);

        //user CAN NOT use old JWT
        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson(route('auth.logout'))
            ->assertUnauthorized();

        //user CAN use new JWT
        $this->withHeader('Authorization', 'Bearer ' . $refreshToken)
            ->postJson(route('auth.logout'))
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'data' => [
                    'message',
                ],
            ]);

        //user after logout CAN NOT refresh JWT
        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson(route('auth.refresh'))
            ->assertUnauthorized();
    }
}
