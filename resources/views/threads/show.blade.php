@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('/css/vendor/jquery.atwho.css') }}">
@endsection

@section('content')
    <thread-view :thread="{{ $thread }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8" v-cloak>
                    @include('threads._topic')

                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>
                                创建于 {{ $thread->created_at->diffForHumans() }} by
                                <a href="#">{{ $thread->creator->name }}</a> 回复数 <span v-text="repliesCount"></span> {{ str_plural('comment',$thread->replies_count) }}
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