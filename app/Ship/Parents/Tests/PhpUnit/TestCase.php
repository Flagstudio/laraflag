<?php

namespace App\Ship\Parents\Tests\PhpUnit;

use App\Ship\Apiato\Abstracts\Tests\PhpUnit\TestCase as AbstractTestCase;

abstract class TestCase extends AbstractTestCase
{
    protected function testingValidationCases(array $cases, string $route): void
    {
        foreach ($cases as $case) {
            $response = $this->postJson($route, $case['request'])
                ->assertJsonMissingValidationErrors($case['success']);

            if ($case['errors']) {
                $response->assertStatus(422)
                    ->assertJsonValidationErrors($case['errors']);
            }
        }
    }
}
