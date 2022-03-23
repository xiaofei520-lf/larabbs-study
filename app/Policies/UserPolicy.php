<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * $currentUser 默认为当前登录用户实例
     * $user        要进行授权的用户实例
     * @Description
     * @Auther 小菜鸟阿飞
     * @Date 2022/3/23 11:23
     */
    public function update(User $currentUser,User $user){
        return $currentUser->id === $user->id;
    }
}
