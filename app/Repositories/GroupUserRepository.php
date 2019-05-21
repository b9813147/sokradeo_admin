<?php

namespace App\Repositories;

use App\Models\GroupUser;
use Yish\Generators\Foundation\Repository\Repository;

class GroupUserRepository extends Repository
{
    protected $model;

    public function __construct(GroupUser $groupUser)
    {
        $this->model = $groupUser;
    }

    public function getUser()
    {
        $select = 'users.name as name, groups.name as group_name ,group_user.member_duty,group_user.member_status,groups.id as group_id,users.id as user_id,users.habook';

        return GroupUser::query()
            ->selectRaw($select)
            ->join('users', 'users.id', 'user_id')
            ->join('groups', 'groups.id', 'group_id')
            ->get();
    }

    /**
     * @param array $column
     * @param array $value
     * @return int
     */
    public function updateByMember(array $column, array $value)
    {
        return GroupUser::query()->where($column)->update($value);
    }

    /**
     * @param array $column
     * @return bool
     */
    public function getMemberExist(array $column)
    {


        return GroupUser::query()
            ->join('users', 'users.id', 'user_id')
            ->join('groups', 'groups.id', 'group_id')
            ->whereNotNull('users.habook')
            ->where($column)->exists();
    }
}
