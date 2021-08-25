<?php

namespace App\Containers\User\Tasks;

use App\Containers\User\Exceptions\SendUserToOneSTaskException;
use App\Ship\OneS\Repositories\OneSRepository;
use App\Ship\Parents\Tasks\Task;

class SendUserToOneSTask extends Task
{
    private OneSRepository $repository;

    public function __construct(OneSRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $fields)
    {
        try {
            $this->repository->update($fields);
        } catch (\Exception $e) {
            throw new SendUserToOneSTaskException;
        }
    }
}
