<div class="col-md-3 col-sm-3">
    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ url('/posts/create') }}" aria-label="Left Align" class="btn btn-success btn-block"><span
                        aria-hidden="true" class="glyphicon glyphicon-pencil"></span> 新建文章
            </a>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            最新评论
        </div>

        <div class="panel-body">
            <ul class="list-group">
                @foreach($comments as $comment)
                    <li class="list-group-item comment-li">
                        <a href="{{ route('profile', $comment->commenter->slug) }}"
                           title="{{ $comment->commenter->name }}">
                            <img src="{{ $comment->commenter->avatar_path }}" class="img-thumbnail" width="30px" alt="">
                        </a>
                        @if(! $comment->child_id)
                            <span class="text-muted">评论了：</span>
                            <a href="{{ route('posts.show', $comment->commentable->slug)}}"
                               title="{{ $comment->commentable->title }}">{{ str_limit($comment->commentable->title, 30, '...') }}
                            </a><span>&nbsp;{{ $comment->created_at->diffForHumans() }}</span><br>
                        @else
                            <span class="text-muted">在 </span><a
                                    href="{{ route('posts.show', $comment->parent->commentable->slug)}}"
                                    title="{{ $comment->parent->commentable->title }}">{{ str_limit($comment->parent->commentable->title, 30, '...') }}</a>
                            <span class="text-muted"> 里，回复了：</span><a
                                    href="{{ route('profile', $comment->parent->commenter->slug) }}">

                                <img src="{{ $comment->parent->commenter->avatar_path }}" class="img-thumbnail"
                                     width="30px" alt="{{ $comment->parent->commenter->name }}"
                                     title="{{ $comment->parent->commenter->name }}">
                            </a><span>&nbsp;{{ $comment->created_at->diffForHumans() }}</span><br>
                        @endif
                        <p>{!! str_limit($comment->comment, 30, '...') !!}</p>
                    </li>
                @endforeach
                {{ $comments->links() }}
            </ul>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            分类
        </div>

        <div class="panel-body">
            <ul class="list-group">
                @foreach($categories as $category)
                    <li class="list-group-item">
                        <a href="{{ url('/posts/categories/' . $category->id) }}">
                            {{ $category->name }} ({{ $category->posts_count }})
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            专题
        </div>

        <div class="panel-body">
            <?php $topicStyle = [
                0 => 'default',
                1 => 'info',
                2 => 'primary',
                3 => 'success',
                4 => 'warning',
                5 => 'danger'
            ];
            $i = 0; ?>
            @foreach($topics as $topic)
                <?php $i++; ?>
                <?php $i = $i == 5 ? 0 : $i;?>
                <a href="{{ url('/posts/topics', [$topic->id]) }}">
                <span class="label label-{{ $topicStyle[$i] }}" style="margin-left: 2px; font-size: 11px">
                    {{ $topic->name }} ({{ $topic->posts_count }})
                </span>
                </a>

            @endforeach
        </div>
    </div>
</div>

