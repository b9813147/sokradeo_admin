<?php

namespace App\Repositories;

use App\Models\User;
use App\Types\Auth\AccountType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use LogicException;
use Yish\Generators\Foundation\Repository\Repository;

class UserRepository extends Repository
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param $userId
     *
     *
     * @return User|User[]|Builder|Builder[]|Collection|Model
     */
    public function getUser($userId)
    {
        return User::with('roles', 'groups')->findOrFail($userId);
    }

    /**
     * @param $AccType
     * @param $accId
     *
     * @return User|User[]|Builder|Builder[]|Collection|Model
     */
    public function getUserByAcc($AccType, $accId)
    {
        $colAcc = AccountType::getDbColNameByAccType($AccType);
        $user   = User::query()->where($colAcc, $accId)->firstOrFail();

        return $this->getUser($user->id);
    }

    public function getUserByClientAcc($clientId, $clientUser)
    {
        $user = User::query()->where('client_id', $clientId)->where('client_user', $clientUser)->firstOrFail();
        return $this->getUser($user->id);
    }

    //
    public function setUser($userId, $userData, $roles)
    {

        $user = $this->update($userId, $userData);
        $user->roles()->sync($roles);
    }

    //
    public function createUserByAcc($accType, $accId, $accData)
    {
        $colAcc = AccountType::getDbColNameByAccType($accType);
        if (User::query()->where($colAcc, $accId)->exists()) {
            throw new LogicException('account is already exist');
        }
        $accData[$colAcc] = $accId;
        $user             = User::create($accData);
        return $this->getUser($user->id);
    }

    //
    public function createUserByClientAcc($clientId, $clientUser, $accData)
    {
        if (User::query()->where('client_id', $clientId)->where('client_user', $clientUser)->exists()) {
            throw new LogicException('account is already exist');
        }
        $accData['client_id']   = $clientId;
        $accData['client_user'] = $clientUser;
        $user                   = $this->create($accData);
        return $this->getUser($user->id);
    }

    //
    public function getUserOrCreateByAcc($accType, $accId, $accData)
    {
        $colAcc = AccountType::getDbColNameByAccType($accType);
        $user   = User::query()->updateOrCreate([$colAcc => $accId], $accData);
        return $this->getUser($user->id);
    }

    //
    public function getUserOrCreateByClientAcc($clientId, $clientUser, $accData)
    {
        $user = User::query()->updateOrCreate(['client_id' => $clientId, 'client_user' => $clientUser], $accData);
        return $this->getUser($user->id);
    }

    //
    public function searchUsers($name)
    {
        if (empty($name)) {
            return [];
        }

        return User::query()->select('id', 'name')->where('name', 'like', $name . '%')->get();
    }

    /**
     * @param int  $perPage
     * @param null $search
     * @return array
     */
    public function getUserAndPaginate($perPage = Null, $search = Null)
    {

        $data = User::query()->where(function ($q) use ($search) {
            if ($search) {
                $q->where('habook', 'like binary', '%' . $search . '%')
                    ->orWhere('client_id', 'like binary', '%' . $search . '%')
                    ->orWhere('client_user', 'like binary', '%' . $search . '%')
                    ->orWhere('email', 'like binary', '%' . $search . '%');
            }
        })->paginate($perPage);


        $response = [
            'data'     => $data,
            'paginate' => [
                'total'        => $data->total(),
                'per_page'     => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page'    => $data->lastPage(),
                'from'         => $data->firstItem(),
                'to'           => $data->lastItem(),
            ]
        ];
        return $response;
    }

    public function search($search)
    {
        $data = User::query()->where(function ($q) use ($search) {
            if ($search) {
                $q->where('habook', 'like binary', '%' . $search . '%')
                    ->orWhere('client_id', 'like binary', '%' . $search . '%')
                    ->orWhere('client_user', 'like binary', '%' . $search . '%')
                    ->orWhere('email', 'like binary', '%' . $search . '%');
            }
        })->get();

        return $data;
    }

}
