@if(count($threads))
<ul class="list-group">
    @foreach ($threads as $thread)
        <li class="list-group-item"><a href="{{ $thread->path() }}">
                {{ $thread->title }}
            </a>
            <span class="meta pull-right">
                {{ $thread->replies_count }} 回复
                <span> ⋅ </span>
                {{ $thread->created_at->diffForHumans() }}</span>
        </li>
    @endforeach
</ul>
@else
    <div class="empty-block">暂无数据 ~_~</div>
@endif
{{ $threads->links() }}