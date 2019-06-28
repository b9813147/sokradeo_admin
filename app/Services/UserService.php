<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Yish\Generators\Foundation\Service\Service;

class UserService extends Service
{
    protected $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * @param $perPage
     * @param $search
     * @return array
     */
    public function getUserAndPaginate($perPage, $search)
    {
        return $this->repository->getUserAndPaginate($perPage, $search);
    }
}
