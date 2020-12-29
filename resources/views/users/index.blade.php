{{-- 列出所有用户 --}}
@extends('layouts.default')
@section('title', '所有用户')

@section('content')
<div class="offset-md-2 col-md-8">
  <h2 class="mb-4 text-center">所有用户</h2>
  <div class="list-group list-group-flush">
    @foreach ($users as $user)
      {{-- 引入user的局部视图 --}}
      @include('users._user')
    @endforeach
  </div>

  {{-- 用户列表分页渲染 --}}
  <div class="mt-3">
    {!! $users->render() !!}
  </div>

</div>
@stop
