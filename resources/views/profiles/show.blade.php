@extends('layouts.app')

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
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">个人资料</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('profiles', [$profileUser->slug]) }}" id="profileForm">
                                {{ csrf_field() }}

                                @method('PUT')

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">名字</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ $profileUser->name }}" autocomplete>

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('origin_password') ? ' has-error' : '' }}">
                                    <label for="origin_password" class="col-md-4 control-label">原密码</label>

                                    <div class="col-md-6">
                                        <input id="origin_password" type="password" class="form-control" name="origin_password" autocomplete>

                                        <span class="help-block">原密码为空就不修改密码！</span>
                                        @if ($errors->has('origin_password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('origin_password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">新密码</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" autocomplete>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 control-label">确认新密码</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="description" class="col-md-4 control-label">个人介绍</label>

                                    <div class="col-md-6">
                                        <textarea  class="form-control" name="description" id="description" cols="30" rows="5">{{ $profileUser->description }}</textarea>

                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="button" id="updateButton" class="btn btn-primary">
                                            保存修改
                                        </button>
                                    </div>
                                </div>
                            </form>
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
                        <a href="#"  data-toggle="modal" data-target="#myModal" style="float: right; margin-top: 10px">修改资料</a>
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
    </div>
@endsection