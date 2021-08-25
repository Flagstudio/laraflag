<?php

namespace App\Ship\Parents\Tests\PhpUnit;

use App\Containers\User\Domain\Entities\User;
use App\Ship\Apiato\Abstracts\Tests\PhpUnit\TestCase as AbstractTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends AbstractTestCase
{
    const JSON_TOKEN_STRUCTURE = [
        'status',
        'data' => [
            'accessToken',
            'expires_in',
        ],
    ];

    protected string $userToken;

    public function setUp(): void
    {
        parent::setUp();

        $this->becomeAuthenticated();
    }

    protected function testingValidationCases(array $cases, string $route, ?string $token = null): void
    {
        foreach ($cases as $case) {
            $response = $this;

            if ($token) {
                $response = $this->asAuthenticated();
            }

            $response = $response->postJson($route, $case['request']);

            if ($case['errors']) {
                $response->assertStatus($case['status'] ?? 422)
                    ->assertJsonValidationErrors($case['errors']);
            } else {
                $this->assertEquals($case['status'] ?? 200, $response->status(), 'Error in case: ' . json_encode($case));
                $response->assertJsonMissingValidationErrors($case['success']);
            }
        }
    }

    protected function becomeAuthenticated(?User $user = null)
    {
        $user = $user ?? User::first();

        if ($user) {
            $this->userToken = JWTAuth::fromUser($user);
        }
    }

    protected function asAuthenticated(): TestCase
    {
        return $this->withHeader('Authorization', 'Bearer ' . $this->userToken);
    }
}
