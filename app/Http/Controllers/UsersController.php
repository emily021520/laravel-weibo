<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{

    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        //compact() 函数创建一个包含变量名和它们的值的数组,并作为第二个参数传递给view方法，将数据与视图进行绑定，这样子就可以得到数据库的信息啦。
        return view('users.show',compact('user'));
    }


    /**
     * 验证规则
     * required 必须要填
     * unique 唯一性
     * min|max 长度验证
     * email 格式验证
     * confirmed 密码匹配验证 保证两次输入的密码一致
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        return;
    }
}
