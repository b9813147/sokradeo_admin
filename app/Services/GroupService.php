<?php

namespace App\Services;

use App\Repositories\GroupRepository;
use Yish\Generators\Foundation\Service\Service;

class GroupService extends Service
{
    protected $repository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->repository = $groupRepository;
    }

    /**
     * 頻道名稱
     * @param $column
     * @return GroupRepository[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getGroupNameList($column)
    {
        return $this->repository->getGroupNameList($column);
    }
}
