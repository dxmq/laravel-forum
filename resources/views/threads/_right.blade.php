<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ url('/threads/create') }}" aria-label="Left Align" class="btn btn-success btn-block"><span
                        aria-hidden="true" class="glyphicon glyphicon-pencil"></span> 新建帖子
            </a>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            专题
        </div>

        <div class="panel-body">
            <?php $channelStyle = [
                0 => 'default',
                1 => 'info',
                2 => 'primary',
                3 => 'success',
                4 => 'warning',
                5 => 'danger'
            ];
            $i = 0;
            ?>
            @foreach($channels as $channel)
                <?php $i++;?>
                <?php $i=$i==5 ? 0 : $i;?>
                <a href="{{ url('/threads', [$channel->slug])}}">
                <span class="label label-{{ $channelStyle[$i] }}" style="margin-left: 2px; font-size: 11px">
                    {{ $channel->name }} ({{ $channel->threads()->count() }})
                </span>
                </a>
            @endforeach
        </div>
    </div>
</div>