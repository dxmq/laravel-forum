@forelse ($threads as $thread)
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <div class="flex">
                    <h4>
                        <a href="{{ $thread->path() }}">
                            @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                <strong>
                                    {{ $thread->title }}
                                </strong>
                            @else
                                {{ $thread->title }}
                            @endif
                        </a>
                    </h4>

                    <h5>
                        发布者：<a href="{{ route('profile',$thread->creator) }}">{{ $thread->creator->name }}</a>
                    </h5>
                </div>

                <a href="{{ $thread->path() }}">
                    {{ $thread->replies_count }}个回复
                </a>
            </div>
        </div>

        <div class="panel-body">
            <div class="body">{!! $thread->body !!}</div>
        </div>

        <div class="panel-footer">
            浏览量 {{ $thread->visits() }}
        </div>
    </div>
@empty
    <p>没有任何话题</p>
@endforelse