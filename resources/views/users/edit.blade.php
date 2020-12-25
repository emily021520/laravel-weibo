@extends('layouts.default')
@section('title', '更新个人资料')

@section('content')
<div class="offset-md-2 col-md-8">
  <div class="card ">
    <div class="card-header">
      <h5>更新个人资料</h5>
    </div>
      <div class="card-body">

        {{-- 导入错误信息 --}}
        @include('shared._errors')

        {{-- 头像 --}}
        <div class="gravatar_edit">
          <a href="http://gravatar.com/emails" target="_blank">
            <img src="{{ $user->gravatar('200') }}" alt="{{ $user->name }}" class="gravatar"/>
          </a>
        </div>

        {{-- 外部跳转链接 相当于http://weibo.test/users/1 --}}
        <form method="POST" action="{{ route('users.update', $user->id )}}">

            {{--
              在RESTful架构中，使用PATCH动作来更新资源，由于浏览器不支持PATCH动作，所以我们需要在表单中添加一个隐藏域来伪造PATCH请求 ==== <input type="hidden" name="_method" value="PATCH">
            --}}
            {{ method_field('PATCH') }}

            {{-- 表单token --}}
            {{ csrf_field() }}

            <div class="form-group">
              <label for="name">名称：</label>
              <input type="text" name="name" class="form-control" value="{{ $user->name }}">
            </div>

            <div class="form-group">
              <label for="email">邮箱：</label>
              {{-- 邮箱不允许修改，加上disabled属性禁用用户输入 --}}
              <input type="text" name="email" class="form-control" value="{{ $user->email }}" disabled>
            </div>

            <div class="form-group">
              <label for="password">密码：</label>
              <input type="password" name="password" class="form-control" value="{{ old('password') }}">
            </div>

            <div class="form-group">
              <label for="password_confirmation">确认密码：</label>
              <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
            </div>

            <button type="submit" class="btn btn-primary">更新</button>
        </form>
    </div>
  </div>
</div>
@stop
