@extends('layouts.app')

@section('title', '个人中心')

@section('content')
    <div class="container">

        <div class="active-box">
            <share></share>
        </div>


        <div class="row">
            <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="media">
                            <div align="center" title="修改头像"><img src="{{ $profileUser->avatar_path }}" width="300px"
                                                                  height="300px"
                                                                  class="thumbnail img-responsive"></div>
                            <footer><span id="stars">关注：{{ $profileUser->stars_count }}</span>｜<span
                                        id="fans">粉丝：{{ $profileUser->fans_count }}</span>｜文章：{{ $profileUser->posts_count }}
                                ｜话题：{{ $profileUser->threads_count }}</footer>

                            @include('layouts.partials._user_like', ['target_user' => $profileUser])
                            <div class="media-body">
                                <hr>
                                <h4><strong>个人简介</strong></h4>
                                <p>{{ $profileUser->description }}</p>
                                <hr>
                                <h4><strong>注册于</strong></h4>
                                <p>{{ $profileUser->created_at->diffForHumans() }}</p>
                                <hr>
                                <h4><strong>最近活动</strong></h4>
                                @foreach($activities as $date => $activity)
                                    <h4 class="page-header">{{ $date }}</h4>

                                    @foreach($activity as $record)
                                        @if($record->subject && $profileUser->id==$record->causer->id)
                                            @if($record->log_name == 'posts')
                                                @include('profiles.activities._post', ['record' => $record])
                                            @elseif($record->log_name == 'threads')
                                                @include('profiles.activities._thread', ['record' => $record])
                                            @elseif($record->log_name == 'favorite')
                                                @include('profiles.activities._favorite', ['record' => $record])
                                            @elseif($record->log_name == 'replies')
                                                @include('profiles.activities._reply', ['record' => $record])
                                                @elseif($record->log_name == 'comments')
                                                @include('profiles.activities._comments', ['record' => $record])
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h1 class="panel-title pull-left" style="font-size: 30px;">{{ $profileUser->name }}
                            <small>{{ $profileUser->email }}</small>
                        </h1>
                        @can('update', $profileUser)
                            <a href="#" data-toggle="modal" data-target="#myModal"
                               style="float: right; margin-top: 10px">修改资料</a>
                        @endcan
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
                        @elseif (request('tab') == 'threads')
                            @include('profiles._threads', ['threads' => $threads])
                        @else
                            @include('profiles._posts', ['posts' => $posts])
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @include('profiles._modal')
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/vendor/bootstrap-prettyfile.js') }}"></script>
    <script>
        $('#updateButton').click(function () {
            $('#profileForm').submit();
        });


        $('#stars').mouseover(function () {
            $('#starsModal').modal('show');
        });

        $('#fans').mouseover(function () {
            $('#fansModal').modal('show');
        });

        $( 'input[type="file"]' ).prettyFile();

        $(".like-button").click(function (event) {
            target = $(event.target);
            var current_like = target.attr("like-value");
            var user_id = target.attr("like-user");
            //var _token = target.attr("_token");
            // 已经关注了
            if (current_like == 1) {
                // 取消关注
                $.ajax({
                    url: "/user/" + user_id + "/unfan",
                    method: "POST",
                    //data: {"_token": _token},
                    dataType: "json",
                    success: function success(data) {
                        if (data.error != 0) {
                            alert(data.msg);
                            return;
                        }

                        target.attr("like-value", 0);
                        target.text("关注");
                    }
                });
            } else {
                // 取消关注
                $.ajax({
                    url: "/user/" + user_id + "/fan",
                    method: "POST",
                    //data: {"_token": _token},
                    dataType: "json",
                    success: function success(data) {
                        if (data.error != 0) {
                            alert(data.msg);
                            return;
                        }

                        target.attr("like-value", 1);
                        target.text("取消关注");
                    }
                });
            }
        });
    </script>

@endsection