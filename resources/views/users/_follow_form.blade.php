{{-- 关注页表单 --}}

{{-- 当用户访问的是自己的个人页面时，关注表单不应该被显示出来 --}}
@can('follow', $user)
  <div class="text-center mt-2 mb-4">
   {{--
      接着，关注表单需要分为两种状态进行显示：
        当用户已被关注时，显示的是取消关注的按钮；
        未被关注时，使用的则是关注按钮。
    --}}

    @if (Auth::user()->isFollowing($user->id))
      <form action="{{ route('followers.destroy', $user->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit" class="btn btn-sm btn-outline-primary">取消关注</button>
      </form>
    @else
      <form action="{{ route('followers.store', $user->id) }}" method="post">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-sm btn-primary">关注</button>
      </form>
    @endif
  </div>
@endcan
