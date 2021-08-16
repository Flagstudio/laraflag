<?php

namespace App\Containers\User\Tasks;

use App\Containers\User\Domain\Entities\User;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GenerateActivationCodeTask extends Task
{
    public function run(User $user)
    {
        try {
            $code = Str::padLeft(rand(0001, 999), 4, 0);

            $user->update([
                'password' => Hash::make($code),
                'verify_code' => $code,
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
