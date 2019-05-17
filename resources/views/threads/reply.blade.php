<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a href="{{ route('profile',$reply->owner) }}"> {{ $reply->owner->name }}</a>
                    回复于
                    {{ $reply->created_at->diffForHumans() }}
                </h5>

                @if(Auth::check())
                    <div>
                        <favorite :reply="{{ $reply }}"></favorite>
                    </div>
                @endif

            </div>
        </div>

        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>

                <button class="btn btn-xs btn-primary" @click="update">更新</button>
                <button class="btn btn-xs btn-link" @click="editing = false">取消</button>
            </div>

            <div v-else v-text="body"></div>
        </div>

        @can('update',$reply)
            <div class="panel-footer level">
                <button class="btn btn-xs mr-1" @click="editing = true">编辑</button>

                <form method="POST" action="/replies/{{ $reply->id }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-danger btn-xs mr-1" @click="destroy">删除</button>
                </form>
            </div>
        @endcan
    </div>
</reply>