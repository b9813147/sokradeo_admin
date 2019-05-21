<?php

namespace App\Repositories;

use App\Models\Group;
use Yish\Generators\Foundation\Repository\Repository;

class GroupRepository extends Repository
{
    protected $model;

    public function __construct(Group $group)
    {
        $this->model = $group;
    }

    public function getGroupNameList($column=['*'])
    {

        return Group::all($column);
    }
}
