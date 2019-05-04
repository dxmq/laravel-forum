@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">{{ $thread->creator->name }}</a>
                        {{ $thread->title }}
                    </div>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>

                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{ $replies->links()}}

                @if (auth()->check())
                    <form method="post" action="{{ $thread->path() . '/replies' }}">

                        {{ csrf_field() }}

                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="说点什么吧..."rows="5"></textarea>
                        </div>

                        <button type="submit" class="btn btn-default">提交</button>
                    </form>
                @else
                    <p class="text-center">请先<a href="{{ route('login') }}">登录</a>，然后再发表回复 </p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            <a href="#">{{ $thread->creator->name }}</a> 发布于 {{ $thread->created_at->diffForHumans() }},
                            当前共有 {{ $thread->replies_count }} 个回复。
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection