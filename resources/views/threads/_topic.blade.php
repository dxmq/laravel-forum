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
            <button class="btn btn-primary btn-xs level-item" @click="update">Update</button>
            <button class="btn btn-xs level-item" @click="resetForm">Cancel</button>

            @can('update',$thread)
                <form action="{{ $thread->path() }}" method="POST" class="ml-a">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-link">Delete Thread</button>
                </form>
            @endcan
        </div>
    </div>
</div>

{{-- View --}}
<div class="panel panel-default" v-else>
    <div class="panel-heading">
        <div class="level">
            @if ($thread->creator->avatar_path)
                <a href="{{ route('profile',$thread->creator) }}">
                    <img src="/storage/{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}" class="mr-1" width="30">
                </a>
            @else
                <a href="{{ route('profile',$thread->creator) }}">
                    <img src="{{ $defaultAvatar }}" alt="avatar">
                </a>
            @endif

            <span class="flex">
                <a href="{{ route('profile',$thread->creator) }}">{{ $thread->creator->name }}</a>： <span
                        v-text="title"></span>
            </span>
        </div>
    </div>

    <div class="panel-body" v-html="body"></div>

    <div class="panel-footer" v-if="authorize('owns',thread)">
        <button class="btn btn-xs" @click="editing = true">Edit</button>
    </div>
</div>