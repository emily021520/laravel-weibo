<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 添加is_admin的布尔值类型字段来判别用户是否拥有管理员身份，该字段默认为false，在迁移文件执行时对该字段进行创建，回滚时则需要对该字段进行移除。
 */
class AddIsAdminToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //用dropColumn方法来对指定字段进行移除
            $table->dropColumn('is_admin');
        });
    }
}
