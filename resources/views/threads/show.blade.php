@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/vendor/jquery.atwho.css') }}">
@endsection

@section('title', '话题详情')

@section('content')
    <thread-view :thread="{{ $thread }}" inline-template>
        <div class="container">
            <div class="active-box">
                <share></share>
            </div>

            <div class="row">
                <div class="col-md-9" v-cloak>
                    @include('threads._topic')

                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>
                </div>

                <div class="col-md-3">
                    @include('threads._new_threads_panel')

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>
                                创建于 {{ $thread->created_at->diffForHumans() }} by
                                <a href="#">{{ $thread->creator->name }}</a> 回复数 <span v-text="repliesCount"></span>
                            </p>

                            <p>
                                <subscribe-button :active="{{ json_encode($thread->isSubscribedTo)}}" v-if="signedIn"></subscribe-button>

                                <button class="btn btn-default"
                                        v-if="authorize('isAdmin')"
                                        @click="toggleLock"
                                        v-text="locked ? '取消锁定' : '锁定'"></button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection