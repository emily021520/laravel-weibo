<?php


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//首页
Route::get('/', 'StaticPagesController@home')->name('home');

//帮助
Route::get('/help', 'StaticPagesController@help')->name('help');

// 关于
Route::get('/about', 'StaticPagesController@about')->name('about');

// 注册
Route::get('signup', 'UsersController@create')->name('signup');

//资源路由 等同于index create show store edit update destroy全一起了 增删改查都有了 包括name=> Route::get('/users/{user}', 'UsersController@show')->name('users.show');
Route::resource('users', 'UsersController');

//显示登录页面
Route::get('login', 'SessionsController@create')->name('login');

//创建新会话(登录)
Route::post('login', 'SessionsController@store')->name('login');

//销毁会话 退出登录
Route::delete('logout', 'SessionsController@destroy')->name('logout');

//用户激活功能 账户激活 最终生成的激活链接为：http://weibo.test/signup/confirm/O1TTEr3faVq4fpzFXaOVQD4EAO9mQL
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');



//忘记密码：填写Email的表单 weibo.test/password/reset
Route::get('password/reset',  'PasswordController@showLinkRequestForm')->name('password.request');

//忘记密码：处理表单提交，成功的话就发送邮件，附带Token的链接
Route::post('password/email',  'PasswordController@sendResetLinkEmail')->name('password.email');

//忘记密码：显示更新密码的表单，包含token
Route::get('password/reset/{token}',  'PasswordController@showResetForm')->name('password.reset');

//忘记密码：对提交过来的token和email数据进行配对，正确的话则更新密码
Route::post('password/reset',  'PasswordController@reset')->name('password.update');

//创建和删除微博
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);

//显示用户的关注人列表
Route::get('/users/{user}/followings', 'UsersController@followings')->name('users.followings');

//显示用户的粉丝列表
Route::get('/users/{user}/followers', 'UsersController@followers')->name('users.followers');

//关注用户
Route::post('/users/followers/{user}', 'FollowersController@store')->name('followers.store');

//取消关注用户
Route::delete('/users/followers/{user}', 'FollowersController@destroy')->name('followers.destroy');
