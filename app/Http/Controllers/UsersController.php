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

        //验证
        $this->validate($request,[
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);


        //用户模型User::create创建之后会返回一个用户对象，并包含新注册用户的所有信息，再将这些值赋值给变量$user，并通过路由跳转来进行数据绑定：redirect()->route('users.show', [$user]); 等同于redirect()->route('users.show', [$user->id]);
        $user = User::create([
            /**
             * 获取所有的值 $data = $request->all();
             */
            'name' => $request->name, //获取输入的name值
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);


        //注册成功 提示信息
        session()->flash('success','欢迎，您将在这里开启一段新的旅程~');

        return redirect()->route('users.show',[$user]);

    }
}
