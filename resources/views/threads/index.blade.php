@extends('layouts.app')

@section('title', '问答')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 topic-list">

                @include('layouts.partials._email_alert')

                @if(!empty($channelName))
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        频道为 "{{ $channelName }}" 下的话题：
                    </div>
                @endif

                <div class="panel panel-default">
                    @if(empty($channelName))
                        <div class="panel-heading">
                            <ul class="nav nav-pills">
                                <li title="按发布时间降序排列"
                                    class="@if(URL::current('threads') && !request('popular') && !request('unanswered')) active @endif">
                                    <a href="/threads">全部</a></li>
                                <li title="按回复数排序"
                                    class="@if(request('popular') && !request('unanswered')) active @endif">
                                    <a href="/threads?popular=1">热门</a></li>
                                <li title="无人问津的话题" class="@if(request('unanswered')) active @endif"><a
                                            href="/threads?unanswered=1">零回复</a></li>
                            </ul>
                        </div>
                    @else
                        <div class="panel-heading">
                            <ul class="nav nav-pills">
                                <li title="按发布时间降序排列"
                                    class="@if(URL::current('threads/' . $channelSlug . '/thread') && !request('popular') && !request('unanswered')) active @endif">
                                    <a href="{{ url('/threads/'.$channelSlug.'/thread') }}">全部</a></li>
                                <li title="按回复数排序"
                                    class="@if(request('popular') && !request('unanswered')) active @endif">
                                    <a href="{{ url('/threads/'.$channelSlug.'/thread?popular=1') }}">热门</a></li>
                                <li title="无人问津的话题" class="@if(request('unanswered')) active @endif"><a
                                            href="{{ url('/threads/'.$channelSlug.'/thread?unanswered=1') }}">零回复</a></li>
                            </ul>
                        </div>
                    @endif
                    <div class="panel-body">
                        <ul class="media-list">
                            @forelse ($threads as $thread)
                                <li class="media">
                                    <div class="media-left">
                                        <a href="{{ route('profile',$thread->creator) }}"
                                           title="{{ $thread->creator->name }}" class="media-object img-thumbnail">
                                            <img width="42" src="{{ $thread->creator->avatar_path }}" alt="无法显示">
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
                                            <a href="/threads/{{ $thread->channel->slug }}/thread"
                                               title="{{ $thread->channel->title }}">
                                                <span aria-hidden="true" class="glyphicon glyphicon-folder-open"></span>
                                                {{ $thread->channel->name }}
                                            </a>
                                            <span> / </span>
                                            <a href="{{ route('profile', $thread->creator->name) }}"
                                               title="{{ $thread->creator->name }}">
                                                <span aria-hidden="true" class="glyphicon glyphicon-user"></span>
                                                {{ $thread->creator->name }}
                                            </a>
                                            <span> / </span>
                                            <span aria-hidden="true" class="glyphicon glyphicon-time"></span>
                                            <span title="最后活跃于"
                                                  class="timeago">{{ $thread->updated_at->diffForHumans()}}</span>
                                            <span> / </span>
                                            <span title="回复数" class="fa fa-reply"></span>
                                            <span title="回复数">{{ $thread->replies()->count() }}</span>
                                            <span> / </span>
                                            <span aria-hidden="true" class="glyphicon glyphicon-eye-open" title="查看数"></span>
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