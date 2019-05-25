@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 topic-list">

               @include('layouts.partials._email_alert')

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-pills">
                            <li title="按回复数排序" class="@if(request('popular') || URL::current('threads') && !request('recently') && !request('unanswered')) active @endif"><a href="/threads?popular=1">热门</a></li>
                            <li title="发布时间排序" class="@if(request('recently')) active @endif"><a href="/threads?recently=1">最近</a></li>
                            <li title="无人问津的话题" class="@if(request('unanswered')) active @endif"><a href="/threads?unanswered=1">零回复</a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <ul class="media-list">
                            @forelse ($threads as $thread)
                            <li class="media">
                                <div class="media-left">
                                    <a href="{{ route('profile',$thread->creator) }}" title="{{ $thread->creator->name }}" class="media-object img-thumbnail">
                                        <img  width="42" src="{{ $thread->creator->avatar_path }}" alt="无法显示">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <div class="media-heading">
                                        <a href="{{ $thread->path() }}" title="{{ $thread->title }}">
                                            @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                                <strong>
                                                    {{ $thread->title }}
                                                </strong>
                                            @else
                                                {{ $thread->title }}
                                            @endif
                                        </a>
                                    </div>
                                    <div class="media-right meta">
                                        <a href="/threads/{{ $thread->channel->slug }}" title="{{ $thread->channel->title }}">
                                            <span aria-hidden="true" class="glyphicon glyphicon-folder-open"></span>
                                             {{ $thread->channel->name }}
                                        </a>
                                        <span> / </span>
                                        <a href="{{ route('profile', $thread->creator->name) }}" title="{{ $thread->creator->name }}">
                                            <span aria-hidden="true" class="glyphicon glyphicon-user"></span>
                                            {{ $thread->creator->name }}
                                        </a>
                                        <span> / </span>
                                        <span aria-hidden="true" class="glyphicon glyphicon-time"></span>
                                        <span title="最后活跃于" class="timeago">{{ $thread->updated_at->diffForHumans()}}</span>
                                        <span> / </span>
                                            <span aria-hidden="true" class="glyphicon glyphicon-eye-open"></span>
                                            <span title="查看数">{{ visits($thread)->count()}}</span>
                                    </div>
                                </div>
                            </li>
                            <hr>
                                @empty
                                暂无话题！
                            @endforelse
                        </ul>
                    </div>
                </div>

                {{ $threads->links() }}
            </div>

            {{-- 右侧部分 --}}
            @include('threads._right')
        </div>
    </div>
@endsection