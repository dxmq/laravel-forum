@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="media">
                            <div align="center"><img src="{{ $profileUser->avatar_path }}" width="300px" height="300px"
                                                     class="thumbnail img-responsive"></div>
                            <div class="media-body">
                                <hr>
                                <h4><strong>个人简介</strong></h4>
                                <p>{{ $profileUser->description }}</p>
                                <hr>
                                <h4><strong>注册于</strong></h4>
                                <p>{{ $profileUser->created_at->diffForHumans() }}</p>
                                <hr>
                                <h4><strong>最近活动</strong></h4>
                                @forelse($activities as $date => $activity)
                                    <h4 class="page-header">{{ $date }}</h4>

                                    @foreach($activity as $record)
                                        @if(view()->exists("profiles.activities.{$record->type}"))
                                            @include("profiles.activities.{$record->type}",['activity'  => $record])
                                        @endif
                                    @endforeach
                                @empty
                                    <p>Ta 仍然没有任何活动。</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body"><span><h1 class="panel-title pull-left" style="font-size: 30px;">{{ $profileUser->name }}
                                <small>{{ $profileUser->email }}</small></h1></span>
                    </div>
                </div>
                <hr>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <ul class="nav nav-tabs">
                            <li @if(URL::current('/profiles/' . $profileUser->slug) && (request('tab') != 'replies') && (request('tab') != 'threads')) class="active" @endif>
                                <a href="{{ route('profile', $profileUser->slug) }}">Ta 的文章</a>
                            </li>
                            <li @if(request('tab') == 'threads') class="active" @endif>
                                <a href="{{ route('profile', $profileUser->slug) }}?tab=threads">Ta 的话题</a>
                            </li>
                            <li @if(request('tab') == 'replies') class="active" @endif>
                                <a href="{{ route('profile', $profileUser->slug) }}?tab=replies">Ta 的回复</a>
                            </li>
                        </ul>
                        @if (request('tab') == 'replies')
                            @include('profiles._replies', ['replies' => $replies])
                        @elseif (request('tab') == 'posts')
                            @include('profiles._threads', ['threads' => $threads])
                        @else
                            @include('profiles._posts', ['posts' => $posts])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection