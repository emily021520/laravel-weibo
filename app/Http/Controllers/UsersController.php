<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
/**
 * 注册用户
 */
class UsersController extends Controller
{

    /**
     * 检验是否登录
     */
    public function __construct()
    {
        //只让未登录用户访问注册页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);


        /**
         * middleware接收两个参数，第一个为中间件的名称，第二个是要进行过滤的动作。
         * 通过except方法来设定指定动作不使用Auth中间件进行过滤，意为，除了此处指定的动作以外，所有其他动作都必须登录才能访问。
         */
        $this->middleware('auth',[
            'except' => ['show','create','store']
        ]);
    }


    /**
     * 列出所有用户并分页展示
     */
    public function index()
    {

        //$users = User::all();
        $users = User::paginate(6);
        return view('users.index', compact('users'));
    }


    /**
     * 显示注册页面
     */
    public function create()
    {
        return view('users.create');
    }



    /**
     * 展示数据
     */
    public function show(User $user)
    {
        //compact() 函数创建一个包含变量名和它们的值的数组,并作为第二个参数传递给view方法，将数据与视图进行绑定，这样子就可以得到数据库的信息啦。
        return view('users.show',compact('user'));
    }


    /**
     * 验证规则 以及注册的逻辑
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

        //用户注册之后自动登录
        Auth::login($user);

        //注册成功 提示信息
        session()->flash('success','欢迎，您将在这里开启一段新的旅程~');

        return redirect()->route('users.show',[$user]);
    }


    /**
     * 编辑用户页面
     * 路由像这样：Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
     * /users/1/edit
     * compact() 函数创建一个包含变量名和它们的值的数组。
     */
    public function edit(User $user)
    {
        //权策略定义完成之后，我们便可以通过在用户控制器中使用 authorize 方法来验证用户授权策略(是否id相同)
        //权限系统(只能对自己用户操作)：https://learnku.com/courses/laravel-essential-training/8.x/permissions-system/9843
        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
    }


    /**
     * 修改逻辑
     */
    public function update(User $user,Request $request)
    {

        $this->authorize('update', $user);

        /**
         * 用户规则的密码那一栏nullable
         * 当用户提供空白密码时也会通过验证，因此我们需要对传入的 password 进行判断，当其值不为空时才将其赋值给 data，避免将空白密码保存到数据库中。
         */
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user);
    }



}
