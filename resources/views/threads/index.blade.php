@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @if(session('email_error') != null)
                    <div class="alert alert-danger">
                        <ul>
                            <li style="color: red">{{ session('email_error') }}</li>
                        </ul>
                    </div>
                @endif

                @if (!Auth::guest() && !auth()->user()->confirmed)
                    <div class="alert alert-warning">
                        <ul>
                            <li>你的邮箱还未验证，这将导致你不能发贴，请前往你的邮箱{{auth()->user()->email}}查收邮件并验证。</li>
                        </ul>
                    </div>
                @endif

                @include ('threads._list')

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
                                <input type="text" placeholder="Search for something..." name="q" class="form-control">
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