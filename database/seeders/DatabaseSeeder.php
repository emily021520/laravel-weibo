<?php
/*
 * @Author: liu shi shi
 * @Date: 2020-12-22 10:21:56
 * @LastEditTime: 2021-01-05 09:29:09
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        /**
         * 用新建模型工厂UsersTableSeeder的方法
         *
         * unguard是临时取消批量赋值（mass assignment）保护，因为此时可能需要批量对 is_admin 等敏感属性进行赋值，而为了安全这是不允许的。
         *
         * laravel 文档中经常会提到 mass assignment，我简单翻译为批量赋值，其实质是为了防止用户恶意注入数据，保护数据的安全。
         *
         * 至此，为什么要 unguard 然后 guard 应该就十分清楚了，从方法名很容易就看出来。为了批量填充数据，当然要暂时性关闭安全保护，填充完毕后重新打开保护。
         */
        Model::unguard();

        $this->call(UsersTableSeeder::class); //用户
        $this->call(StatusesTableSeeder::class); //权限 管理员
        $this->call(FollowersTableSeeder::class); //用户关注

        Model::reguard();
    }
}
