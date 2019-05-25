@if(count($posts))
<ul class="list-group">
    @foreach ($posts as $post)
        <li class="list-group-item"><a href="{{ url('/posts', [$post->slug]) }}">
                {{ $post->title }}
            </a>
            <span class="meta pull-right">
                {{ $post->comments->count() }} 个评论
                <span> ⋅ </span>
                {{ $post->created_at->diffForHumans() }}</span>
        </li>
    @endforeach
</ul>
@else
    <div class="empty-block">暂无数据 ~_~</div>
@endif
{{ $posts->links() }}