<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
   
    use HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * Gravatar 头像和侧边栏
     * 用途：可以直接在视图中通过以下方法进行调用
     * 比如：使用默认尺寸来获取头像 $user->gravatar();
     * 为gravatar指定尺寸大小来获取头像：$user->gravatar('140')
     * 为 gravatar 方法传递的参数 size 指定了默认值 100；
     * 通过 $this->attributes['email'] 获取到用户的邮箱；
     * 使用 trim 方法剔除邮箱的前后空白内容；
     * 用 strtolower 方法将邮箱转换为小写；
     * 将小写的邮箱使用 md5 方法进行转码；
     * 将转码后的邮箱与链接、尺寸拼接成完整的 URL 并返回
     *
     * @param string $size
     * @return void
     */
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }


    /**
     * The attributes that are mass assignable.
     * 可批量分配的属性
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     * 应该为数组隐藏的属性
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     * 应强制转换为本机类型的属性
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * 生成令牌
     */
    public static function boot()
    {
        //在用户模型类完成初始化之后进行加载，因此对事件的监听需要放在该方法中
        parent::boot();

        static::creating(function ($user){
            $user->activation_token = Str::random(10);
        });
    }


    /**
     * 一对多关联 用户和微博之间的关联
     */
    public function statuses()
    {
        //一个用户拥有多条微博
        return $this->hasMany(Status::class);
    }






}
