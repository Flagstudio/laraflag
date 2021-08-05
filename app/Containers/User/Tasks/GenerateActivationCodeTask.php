<?php

namespace App\Containers\User\Tasks;

use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\Auth;

class GenerateActivationCodeTask extends Task
{
    public function run()
    {
        try {
            Auth::user()->update([
                'verify_code' => rand(1111, 9999),
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
