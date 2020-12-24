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
}
