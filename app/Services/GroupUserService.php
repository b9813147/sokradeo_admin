<?php

namespace App\Services;

use App\Repositories\GroupUserRepository;
use http\Env\Response;
use Yish\Generators\Foundation\Service\Service;

class GroupUserService extends Service
{
    protected $repository;

    public function __construct(GroupUserRepository $groupUserRepository)
    {
        $this->repository = $groupUserRepository;
    }
    /**
     * 取得頻道使用者
     * @return GroupUserRepository[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getUser()
    {
        return $this->repository->getUser();
    }

    /**
     * @param array $column
     * @param array $value
     * @return int
     */
    public function updateByMember(array $column, array $value)
    {
        return $this->repository->updateByMember($column, $value);
    }

    /**
     * @param array $column
     * @return bool
     */
    public function getMemberExist(array $column)
    {
        return $this->repository->getMemberExist($column);
    }
}
