<?php

namespace App\Services;

use App\Repositories\GroupChannelRepository;
use Yish\Generators\Foundation\Service\Service;

class GroupChannelService extends Service
{
    protected $repository;

    public function __construct(GroupChannelRepository $groupChannelRepository)
    {
        $this->repository = $groupChannelRepository;
    }
}
