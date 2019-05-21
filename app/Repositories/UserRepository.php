<?php

namespace App\Repositories;

use App\Models\User;
use App\Types\Auth\AccountType;
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
     * @return User|User[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getUser($userId)
    {
        return User::with('roles', 'groups')->findOrFail($userId);
    }

    /**
     * @param $AccType
     * @param $accId
     *
     * @return User|User[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
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

}
