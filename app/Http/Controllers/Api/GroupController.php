<?php

namespace App\Http\Controllers\Api;

use App\Services\GroupService;
use App\Services\GroupUserService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

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

    /**
     * 取得頻道名稱列表
     *
     * @return JsonResponse
     */
    public function getGroupAll()
    {
        $groups = $this->groupService->getGroupNameList('*');

        return Response::json($groups);
    }
    /**
     * 取得頻道使用者列表
     *
     * @return JsonResponse
     */
    public function getGroupUserAll()
    {

        $users = $this->groupUserService->getUser();

        return Response::json($users);
    }
    /**
     * 檢查頻道使用者存不存在
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getMemberGroupExist(Request $request)
    {

        if (!$this->groupUserService->getMemberExist(['users.habook' => $request->habook])){
            return Response::json('habook not found');
        }

        $exist = $this->groupUserService->getMemberExist(['users.habook' => $request->habook, 'group_id' => $request->group_id]);

        return Response::json($exist);
    }
}
