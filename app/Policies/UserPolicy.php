<?php


namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * 用户授权策略类
 */
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
     * 修改用户动作相关的授权
     * $currentUser 当前登录用户实例
     * $user 进行授权的用户实例
     * 如果两个id相同，则代表两个用户是相同用户，用户通过授权，可以接着进行下一个操作，如果id不相同，则抛出403异常信息拒绝访问
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    /**
     *
     * 删除用户动作相关的授权
     */
    public function destroy(User $currentUser, User $user)
    {
        //只有当前用户拥有管理员权限且删除的用户不是自己时才显示链接
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }

    /**
     * 关注用户和取消关注，都要做授权判断
     * 在开发一个功能前，需仔细考虑下此功能的授权策略。在我们的场景中，什么人不能关注用户？是的，自己不能关注自己。故新增授权策略方法取名 follow()
     */
    public function follow(User $currentUser, User $user)
    {
        return $currentUser->id !== $user->id;
    }
}
