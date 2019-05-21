<?php

namespace App\Http\Controllers\Api;

use App\Services\GroupService;
use App\Services\GroupUserService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    protected $groupService;
    protected $userService;
    protected $groupUserService;

    public function __construct(GroupService $groupService, UserService $userService, GroupUserService $groupUserService)
    {
        $this->groupService     = $groupService;
        $this->userService      = $userService;
        $this->groupUserService = $groupUserService;
    }

    public function getGroupAll()
    {
        $groups = $this->groupService->getGroupNameList('*');

        return \Response::json($groups);
    }

    public function getGroupUserAll()
    {

        $users = $this->groupUserService->getUser();

        return \Response::json($users);

    }

    public function getMemberGroupExist(Request $request)
    {

        if (!$this->groupUserService->getMemberExist(['users.habook' => $request->habook])){
            return \Response::json('habook not found');
        }

        $exist = $this->groupUserService->getMemberExist(['users.habook' => $request->habook, 'group_id' => $request->group_id]);


        return \Response::json($exist);
    }
}
