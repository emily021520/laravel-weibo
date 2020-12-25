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
     * $currentUser 当前登录用户实例
     * $user 进行授权的用户实例
     * 如果两个id相同，则代表两个用户是相同用户，用户通过授权，可以接着进行下一个操作，如果id不相同，则抛出403异常信息拒绝访问
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
}
