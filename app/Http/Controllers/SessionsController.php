<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 用户登录
 */
class SessionsController extends Controller
{

    /**
     * 显示表单页面
     */
    public function create()
    {
        return view('sessions.create');
    }


    /**
     * 处理登录逻辑
     */
    public function store(Request $request)
    {

        /**
         * 验证
         */
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);


        /**
         * attempt()第一个参数是进行用户身份认证的数组，第二个参数为是否为用户开启【记住我】功能的布尔值，括号里面的值是表单里的name值
         */
        if (Auth::attempt($credentials, $request->has('remember'))) {
            session()->flash('success', '欢迎回来！');
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }


    /**
     * 退出登录
     */
    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您已成功退出！');
        return redirect('login'); //并跳转到登录页面
    }



}
