@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @if ($threads->total() && !empty($search))
                    <div class="alert alert-success" role="alert">
                        下面是搜索"{{$search}}"出现的话题，共{{$threads->total()}}条
                    </div>
                @else
                    <div class="alert alert-warning" role="alert">
                        没有关键词为"{{$search}}"话题，<a href="/threads">返回首页</a>
                    </div>
                @endif

                @foreach ($threads as $thread)
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
                                        发布者：<a
                                                href="{{ route('profile',$thread->creator) }}">{{ $thread->creator->name }}</a>
                                    </h5>
                                </div>

                                <a href="{{ $thread->path() }}">
                                    {{ $thread->replies_count }}个回复
                                </a>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="body">{{ $thread->body }}</div>
                        </div>

                        <div class="panel-footer">
                            浏览量 {{ $thread->visits() }}
                        </div>
                    </div>
                @endforeach

                {{ $threads->render() }}

            </div>


            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        搜索
                    </div>

                    <div class="panel-body">
                        <form method="GET" action="/threads/search">
                            <div class="form-group">
                                <input type="text" placeholder="Search for something..." name="q" class="form-control"
                                       value="@if($search){{ $search }}@endif">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-default" type="submit">搜索</button>
                            </div>
                        </form>
                    </div>
                </div>

                @if (count($trending))
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            活跃话题
                        </div>

                        <div class="panel-body">
                            <ul class="list-group">
                                @foreach ($trending as $thread)
                                    <li class="list-group-item">
                                        <a href="{{ url($thread->path) }}">
                                            {{ $thread->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection