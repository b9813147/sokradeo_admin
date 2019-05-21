<?php

namespace App\Repositories;

use App\Models\GroupChannel;
use Yish\Generators\Foundation\Repository\Repository;

class GroupChannelRepository extends Repository
{
    protected $model;

    public function __construct(GroupChannel $groupChannel)
    {
        $this->model = $groupChannel;
    }
}
