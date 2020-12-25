@extends('layouts.default')
@section('title', '注册')

@section('content')
<div class="offset-md-2 col-md-8">
  <div class="card ">
    <div class="card-header">
      <h5>注册</h5>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('users.store') }}">
        {{ csrf_field() }}

        {{--
          经过POST方法提交时，Laravel 为了安全考虑，会让我们提供一个 token（令牌）来防止我们的应用受到 CSRF（跨站请求伪造）的攻击。

          上方调用如 <input type="hidden" name="_token" value="fhcxqT67dNowMoWsAHGGPJOAWJn8x5R5ctSwZrAq">

          CSRF 令牌基于会话（Session），过期时间在 config/session.php 文件中的 lifetime 选项做设定，默认为 2 个小时。
        --}}



          {{-- 引用表单错误信息 --}}
          @include('shared._errors')



        <div class="form-group">
          <label for="name">名称：</label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="form-group">
          <label for="email">邮箱：</label>
          <input type="text" name="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="form-group">
          <label for="password">密码：</label>
          <input type="password" name="password" class="form-control" value="{{ old('password') }}">
        </div>

        <div class="form-group">
          <label for="password_confirmation">确认密码：</label>
          <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
        </div>

        <button type="submit" class="btn btn-primary">注册</button>
      </form>
    </div>
  </div>
</div>
@stop
