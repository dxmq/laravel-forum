@if (count($replies))

    <ul class="list-group">
        @foreach ($replies as $reply)
            <li class="list-group-item">
                回复
                <a href="{{ $reply->thread->path() }}">
                    {{ $reply->thread->title }}
                </a>
                <span class="meta pull-right">
                    {{ $reply->created_at->diffForHumans() }}</span>
            </li>
        @endforeach
    </ul>

@else
    <div class="empty-block">暂无数据 ~_~</div>
@endif

{{-- 分页 --}}
{{ $replies->links() }}