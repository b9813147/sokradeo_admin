<?php

namespace App\Http\Controllers\AuthBack;

use App\Services\ApiHaBookService;
use App\Services\Auth\UserService;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login()
    {

        auth()->logout();

        return view('welcome');
    }

    public function loginAsHaBook(Request $request)
    {
//        auth()->logout();

        $to = is_null($request->to) ? url()->previous() : $request->to;

        if ($to === 'default') {
            $to = route('admin.personnel.index');
        }

        $url = \Config::get('server.haBook.account.url');

        $url = $url . '?callback=' . route('auth.login.callbackHaBook') . '?to=' . $to;

//        dd($url);
        return redirect($url);
    }

    /**
     * @param Request $request
     * @param ApiHaBookService $apiHaBookService
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function callbackHaBook(Request $request, ApiHaBookService $apiHaBookService)
    {
        auth()->logout();

        $to     = $request->to;
        $ticket = $request->ticket;

        if (!filter_var($to, FILTER_VALIDATE_URL)) {
            $to = base64_decode($request->to);
        }

        try {

            $userInfo = $apiHaBookService->getUserInfo($ticket);

        } catch (Exception $e) {
            return redirect()->route('auth.login');
        }

        $accId = $userInfo->id;

        $accData = [
            'name'  => $userInfo->name,
            'email' => $userInfo->email,
        ];
        $user    = $this->userService->loginAsHabook($accId, $accData);

        $this->userService->signin($user);

        return is_null($to) ? redirect()->route('admin.personnel.index') : redirect($to);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('auth.login');
    }

    public function changCallbackUrl()
    {
        $url = config('server.haBook.account.url') . 'logout?callback=' . route('admin.personnel.index');

        return view('logout', compact('url'));
    }
}
