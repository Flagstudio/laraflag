<?php

namespace App\Ship\Parents\Tests\PhpUnit;

use App\Containers\User\Domain\Entities\User;
use App\Ship\Apiato\Abstracts\Tests\PhpUnit\TestCase as AbstractTestCase;
use App\Ship\OneS\Repositories\OneSRepository;
use Illuminate\Http\Client\Request;
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

    protected OneSRepository $repository;

    protected string $userToken;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new OneSRepository();

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

    protected function sendOneSGetUser(string $phone): \Closure
    {
        $params = [
            'phone' => $phone,
        ];

        return function (Request $request) use ($params) {
            return $request->url() === $this->repository->getUrlFindUser($params)
                && $request['phone'] === $params['phone'];
        };
    }

    protected function sendOneSCreateUser(string $phone, string $name): \Closure
    {
        $params = [
            'phone' => $phone,
            'name' => $name,
        ];

        return function (Request $request) use ($params) {
            return $request->url() === $this->repository->getUrlCreateUser($params)
                && $request['phone'] === $params['phone']
                && $request['name'] === $params['name'];
        };
    }

    protected function sendOneSUpdateUser(array $params): \Closure
    {
        return function (Request $request) use ($params) {
            return $request->url() === $this->repository->getUrlUpdateUser($params)
                && $request['phone'] === $params['phone']
                && $request['name'] === $params['name'];
        };
    }

    protected function becomeAuthenticated(?User $user = null)
    {
        $user = $user ?? User::first();
        $this->userToken = JWTAuth::fromUser($user);
    }

    protected function asAuthenticated(): TestCase
    {
        return $this->withHeader('Authorization', 'Bearer ' . $this->userToken);
    }
}
