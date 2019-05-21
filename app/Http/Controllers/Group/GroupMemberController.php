<?php

namespace App\Http\Controllers\Group;

use App\Services\GroupUserService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupMemberController extends Controller
{
    protected $userService;
    protected $groupUserService;

    public function __construct(UserService $userService, GroupUserService $groupUserService)
    {
        $this->userService      = $userService;
        $this->groupUserService = $groupUserService;
    }

    public function index()
    {

        return view('group.member');

    }

    public function update(Request $request)
    {
        return $this->groupUserService->updateByMember([
            'user_id'  => $request->user_id,
            'group_id' => $request->group_id
        ], [
            'member_duty'   => $request->member_duty,
            'member_status' => $request->member_status,
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
