{{-- Edit --}}
<div class="panel panel-default" v-if="editing">
    <div class="panel-heading">
        <div class="level">
            <input type="text" class="form-control" v-model="form.title">
        </div>
    </div>

    <div class="panel-body">
        <div class="form-group">
            <wysiwyg v-model="form.body" :value="form.body"></wysiwyg>
        </div>
    </div>

    <div class="panel-footer">
        <div class="level">
            <button class="btn btn-primary btn-xs level-item" @click="update">更新</button>
            <button class="btn btn-xs level-item" @click="resetForm">取消</button>

            @can('update',$thread)
                <form action="{{ $thread->path() }}" method="POST" class="ml-a">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-link">删除话题</button>
                </form>
            @endcan
        </div>
    </div>
</div>

{{-- View --}}
<div class="panel panel-default" v-else>
    <div class="panel-heading">
        <div class="level">
            <a href="{{ route('profile',$thread->creator) }}">
                <a href="{{ route('profile',$thread->creator) }}" title="{{ $thread->creator->avatar_path }}" class="media-object img-thumbnail">
                    <img  width="30" src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}">
                </a>
            </a>

            <span class="flex" style="margin-left: 10px">
                <a href="{{ route('profile',$thread->creator->slug) }}">{{ $thread->creator->name }}</a>： <span
                        v-text="title"></span>
            </span>
        </div>
    </div>

    <div class="panel-body" v-html="body"></div>

    <div class="panel-footer" v-if="authorize('owns',thread)">
        <button class="btn btn-xs" @click="editing = true">编辑</button>
    </div>
</div>