<?php

namespace App\Containers\User\Tasks;

use App\Containers\User\Domain\Repositories\UserRepository;
use App\Containers\User\Exceptions\UserNotFoundException;
use App\Ship\Parents\Tasks\Task;

class FindUserByPhoneTask extends Task
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $phone)
    {
        try {
            return $this->repository->getByPhone($phone);
        } catch (\Exception $e) {
            throw new UserNotFoundException;
        }
    }
}
