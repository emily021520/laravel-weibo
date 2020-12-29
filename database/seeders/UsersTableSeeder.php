<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

/**
 * 模型工厂 新建的
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * User::factory() 返回的是一个 UserFactory 对象。模型工厂相关的功能在 app/Models/User.php 模型类的顶部，加载了 HasFactory trait 实现的。
         *
         */
        User::factory()->count(50)->create();

        $user = User::find(1);
        $user->name = 'Summer';
        $user->email = 'summer@example.com';
        $user->save();
    }
}
