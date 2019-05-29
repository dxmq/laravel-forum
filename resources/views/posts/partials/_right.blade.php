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
                <?php $i=$i==5 ? 0 : $i;?>
                <a href="{{ url('/posts/topics', [$topic->id]) }}">
                <span class="label label-{{ $topicStyle[$i] }}" style="margin-left: 2px; font-size: 11px">
                    {{ $topic->name }} ({{ $topic->posts_count }})
                </span>
                </a>

            @endforeach
        </div>
    </div>
</div>

