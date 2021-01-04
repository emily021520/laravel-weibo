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



    /**
     * 将当前用户发布过的所有微博从数据库中取出，并根据创建时间来倒叙排序
     */
    public function feed()
    {
        return $this->statuses()
                    ->orderBy('created_at', 'desc');
    }


    /**
     * 获取粉丝关系列表
     * 多对多关系，一个用户(粉丝)能够关注多个人，而被关注着能够拥有多个粉丝
     */
    public function followers()
    {
        return $this->belongsToMany(User::Class, 'followers', 'user_id', 'follower_id');
    }


    /**
     * 获取用户关注人的列表
     */
    public function followings()
    {
        return $this->belongsToMany(User::Class, 'followers', 'follower_id', 'user_id');
    }


    /**
     * 关注
     */
    public function follow($user_ids)
    {
        //is_array 用于判断参数是否为数组，如果已经是数组，则没有必要再使用 compact 方法
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        //我们并没有给 sync 和 detach 指定传递参数为用户的 id，这两个方法会自动获取数组中的 id。
        $this->followings()->sync($user_ids, false);
    }


    /**
     * 取消关注
     */
    public function unfollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }


    /**
     * 判断当前登录的用户 A 是否关注了用户 B，代码实现逻辑很简单，我们只需判断用户 B 是否包含在用户 A 的关注人列表上即可。这里我们将用到 contains 方法来做判断。
     */
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }

}
