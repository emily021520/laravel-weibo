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
     * 只让未登录用户访问登录页面
     */
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }


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
         *
         * intended方法可将页面重定向到上一次请求尝试访问的页面上，并接收一个默认跳转地址参数，当上一次请求记录为空时，跳转到默认地址上。(当一个未登录的用户尝试访问自己的资料编辑页面时，将会自动跳转到登录页面，这时候如果用户再进行登录，则会重定向到其个人中心页面上，这种方式的用户体验并不好。更好的做法是，将用户重定向到他之前尝试访问的页面，即自己的个人编辑页面。)
         */
        if (Auth::attempt($credentials, $request->has('remember'))) {
            //登录时检查是否已激活
            if (Auth::user()->activated) {
                session()->flash('success', '欢迎回来！');
                $fallback = route('users.show', Auth::user());
                return redirect()->intended($fallback);
            } else {
                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }
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
