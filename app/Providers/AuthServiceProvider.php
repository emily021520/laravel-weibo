<?php
/*
 * @Author: liu shi shi
 * @Date: 2020-12-22 10:21:56
 * @LastEditTime: 2020-12-25 16:52:27
 */

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * 修改策略自动发现的逻辑
         * 权策略定义完成之后，我们便可以通过在用户控制器中使用 authorize 方法来验证用户授权策略。默认的 App\Http\Controllers\Controller 类包含了 Laravel 的 AuthorizesRequests trait。此 trait 提供了 authorize 方法，它可以被用于快速授权一个指定的行为，当无权限运行该行为时会抛出 HttpException。authorize 方法接收两个参数，第一个为授权策略的名称，第二个为进行授权验证的数据。
         * 我们需要为 edit 和 update 方法加上这行：
         * $this->authorize('update', $user);
         */
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            // 动态返回模型对应的策略名称，如：// 'App\Models\User' => 'App\Policies\UserPolicy',
            return 'App\Policies\\' . class_basename($modelClass) . 'Policy';
        });
    }
}
