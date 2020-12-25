@foreach (['danger', 'warning', 'success', 'info'] as $msg)
  @if(session()->has($msg))  {{-- 判断这个值是否为空 如果为空就不显示--}}
    <div class="flash-message">
      <p class="alert alert-{{ $msg }}">
        {{ session()->get($msg) }}  {{-- 取出对应的值在页面上显示 --}}
      </p>
    </div>
  @endif
@endforeach
