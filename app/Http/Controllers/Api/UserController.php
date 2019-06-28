<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 取得全部使用者
     *
     * @param Request $request
     * @return UserService[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUserAll(Request $request)
    {

//        $perPage = $request->per_page;
//        $search = $request->search;
//        return $this->userService->getUserAndPaginate($perPage,$search);
        return $this->userService->getUserAll();

    }
}
