{{-- 关注modal --}}
<div class="modal fade" id="starsModal" tabindex="-1" role="dialog" aria-labelledby="stars">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="stars">关注的用户</h4>
            </div>
            <div class="modal-body">
                @if(count($stars))
                    @foreach ($stars as $star)
                        <a href="{{ route('profile', $star->suser->slug)  }}">
                            <img src="{{ $star->suser->avatar_path }}" alt="{{ $star->suser->name }}" title="{{ $star->suser->name }}" width="35px" class="img-circle">
                            {{ $star->suser->name }}
                        </a>
                        <span>&nbsp;&nbsp;</span>
                    @endforeach
                @else
                    还没有关注
                @endif
            </div>

        </div>
    </div>
</div>

{{-- 粉丝modal --}}
<div class="modal fade" id="fansModal" tabindex="-1" role="dialog" aria-labelledby="fans">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="fans">粉丝</h4>
            </div>
            <div class="modal-body">
                @if(count($fans))
                    @foreach ($fans as $fan)
                        <a href="{{ route('profile', $fan->fuser->slug)  }}">
                            <img src="{{ $fan->fuser->avatar_path }}" alt="{{ $fan->fuser->name }}" title="{{ $fan->fuser->name }}" width="35px" class="img-circle">
                            {{ $fan->fuser->name }}
                        </a>
                        <span>&nbsp;&nbsp;</span>
                    @endforeach
                @else
                    还没有粉丝诶！
                @endif
            </div>

        </div>
    </div>
</div>

<!-- 修改资料 Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">个人资料</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{ url('profiles', [$profileUser->slug]) }}" id="profileForm" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @method('PUT')

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">名字</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name"
                                   value="{{ $profileUser->name }}" autocomplete required>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">头像</label>

                        <div class="col-md-6">
                            <input id="avatar" type="file" class="form-control" name="avatar" autocomplete multiple="multiple">

                            @if ($errors->has('avatar'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('origin_password') ? ' has-error' : '' }}">
                        <label for="origin_password" class="col-md-4 control-label">原密码</label>

                        <div class="col-md-6">
                            <input id="origin_password" type="password" class="form-control"
                                   name="origin_password" autocomplete>

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
                            <input id="password" type="password" class="form-control" name="password"
                                   autocomplete>
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
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" autocomplete>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="col-md-4 control-label">个人介绍</label>

                        <div class="col-md-6">
                                        <textarea class="form-control" name="description" id="description" cols="30"
                                                  rows="5">{{ $profileUser->description }}</textarea>

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

