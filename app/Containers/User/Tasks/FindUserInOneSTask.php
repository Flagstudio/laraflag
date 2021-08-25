<?php

namespace App\Containers\User\Tasks;

use App\Containers\User\Exceptions\SearchUserInOneSException;
use App\Ship\OneS\Repositories\OneSRepository;
use App\Ship\Parents\Tasks\Task;

class FindUserInOneSTask extends Task
{
    private OneSRepository $repository;

    public function __construct(OneSRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $phone)
    {
        try {
            return $this->repository->getUserByPhone([
                'phone' => $phone,
            ]);
        } catch (\Exception $e) {
            throw new SearchUserInOneSException;
        }
    }
}
