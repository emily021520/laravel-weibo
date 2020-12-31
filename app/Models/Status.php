<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 用户和微博之间的关联
 * 一对一
 * 一对多
 * 多对多
 * 远程一对多
 * 多态关联
 * 多态多对多关联
 */
class Status extends Model
{
    use HasFactory;
    
    //来指定在微博模型中可以进行正常更新的字段，Laravel 在尝试保护。解决的办法很简单，在微博模型的 fillable 属性中允许更新微博的 content 字段即可
    protected $fillable = ['content'];

    /**
     * 一对一关联
     */
    public function user()
    {
        // 一条微博属于一个用户
        return $this->belongsTo(User::class);
    }
}
