{{-- 基本html5的样式 基本视图 --}}
<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'Weibo App') - Laravel 入门教程</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  </head>

  <body>
    @include('layouts._header')

    <div class="container">
      <div class="offset-md-1 col-md-10">
        @include('shared._messages') {{-- 数据库数据信息 --}}
        @yield('content') {{-- 内容 --}}
        @include('layouts._footer') {{-- 底部 --}}
      </div>
    </div>

    {{-- 引用js库 实现JavaScript动起来的感觉 --}}
    <script src="{{ mix('js/app.js') }}"></script>
  </body>
</html>
