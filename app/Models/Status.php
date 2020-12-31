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


    /**
     * 一对一关联
     */
    public function user()
    {
        // 一条微博属于一个用户
        return $this->belongsTo(User::class);
    }

    /**
     * 一对多关联
     */
    public function statuses()
    {
        //一个用户拥有多条微博
        return $this->hasMany(Status::class);
    }
}
