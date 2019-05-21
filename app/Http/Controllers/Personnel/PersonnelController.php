<?php

namespace App\Http\Controllers\Personnel;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PersonnelController extends Controller
{

    public function index()
    {
        return view('channel.index');
    }
    public function getAll()
    {

        $users = User::all();

        $data=[];
        $users->each(function ($v, $k) {
            $data[] = [
                'roles' => $v->roles()->get(),
                'users' => $v,
            ];
            dd($data);
        });

//
        return \Response::json($data, 200);
//        foreach ($roles as $role) {
//            $data[] = [
//                'role' => $role,
//                'user' => $u,
//            ];
//        }
//        return $role;
//        dd($role);
        //新增
//        $u->roles()->attach(4);
        //刪除
//        $u->roles()->detach(4);
        $roles = $u->roles()->get();
        foreach ($roles as $role) {
//            $role->user  = $u->name;
//            $role->email = $u->email;
            $data[] = [
                'role' => $role,
                'user' => $u,
            ];
            unset($role->pivot);
        }


        return $data;
//        dd($u->roles()->get());
//        App\User::find(1)->roles()->save($role, ['expires' => $expires]);
//            return $u->roles()->name;

//       return User::query()->with('roles')->find(1);

    }

}
