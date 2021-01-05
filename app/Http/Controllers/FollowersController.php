<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * 关注用户
 * 取消关注用户
 */
class FollowersController extends Controller
{

    //必须要登录之后参那个操作 由于用户不能对自己进行关注和取消关注，因此我们在 store 和 destroy 方法中都对用户身份做了授权判断
    public function __construct()
    {
        $this->middleware('auth');
    }

    //关注
    public function store(User $user)
    {
        $this->authorize('follow', $user);

        //为了使代码逻辑更加严谨，在进行关注和取消关注操作之前，我们还会利用 isFollowing 方法来判断当前用户是否已关注了要进行操作的用户。
        if (!Auth::user()->isFollowing($user->id)) {
            Auth::user()->follow($user->id);
        }

        return redirect()->route('users.show', $user->id);
    }

    //取消关注
    public function destroy(User $user)
    {
        $this->authorize('follow', $user);

        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unfollow($user->id);
        }

        return redirect()->route('users.show', $user->id);
    }
}
