@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                            <span class="flex">
                                <a href="{{ route('profile',$thread->creator) }}">{{ $thread->creator->name }}</a>
                                {{ $thread->title }}
                            </span>

                                @can('update',$thread)
                                    <form action="{{ $thread->path() }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" class="btn btn-link">Delete Thread</button>
                                    </form>
                                @endcan
                            </div>
                        </div>

                        <div class="panel-body">
                            {{ $thread->body }}
                        </div>
                    </div>

                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>

                    {{--@foreach ($replies as $reply)--}}
                    {{--@include('threads.reply')--}}
                    {{--@endforeach--}}

                    {{--{{ $replies->links() }}--}}

                    {{--@if (auth()->check())
                        <form method="post" action="{{ $thread->path() . '/replies' }}">

                            {{ csrf_field() }}

                            <div class="form-group">
                                <textarea name="body" id="body" class="form-control" placeholder="说点什么吧..."rows="5"></textarea>
                            </div>

                            <button type="submit" class="btn btn-default">提交</button>
                        </form>
                    @else
                        <p class="text-center">请先<a href="{{ route('login') }}">登录</a>，然后再发表回复 </p>
                    @endif--}}
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>
                                <a href="#">{{ $thread->creator->name }}</a> 发布于 {{ $thread->created_at->diffForHumans() }},
                                当前共有 <span v-text="repliesCount"></span> 个回复。
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection