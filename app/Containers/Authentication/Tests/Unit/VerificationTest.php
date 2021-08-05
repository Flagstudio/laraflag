<?php

namespace App\Containers\Authentication\Tests\Unit;

use App\Containers\User\Domain\Entities\User;
use App\Ship\Parents\Tests\PhpUnit\TestCase;
use Illuminate\Support\Facades\Auth;

class VerificationTest extends TestCase
{
    const CODE = '1234';
    const WRONG_CODE = '4321';

    public function test_user_can_verify_code()
    {
        $user = User::factory()->create([
            'verify_code' => self::CODE,
        ]);

        Auth::login($user);

        $request = [
            'verify_code' => self::CODE,
        ];

        $this->ajaxGet(route('auth.verify'), $request)
            ->assertOk();
    }

    public function test_user_send_wrong_code()
    {
        $user = User::factory()->create([
            'verify_code' => self::CODE,
        ]);

        Auth::login($user);

        $request = [
            'verify_code' => self::WRONG_CODE,
        ];

        $this->ajaxGet(route('auth.verify'), $request)
            ->assertStatus(400);
    }
}
