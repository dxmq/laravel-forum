@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/prism-a11y-dark.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="active-box">
            <share></share>
        </div>

        <div class="row">

            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <div class="flex">
                                <div class="media-left">
                                    <a href="{{ route('profile', $post->creator->slug) }}"
                                       title="{{ $post->creator->name }}">
                                        <img class="media-object img-thumbnail" width="40px"
                                             src="{{ $post->creator->avatar_path }}"
                                             alt="{{ $post->creator->name }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4>{{ $post->title }}</h4>
                                </div>

                                <div class="media-bottom">
                                    <span title="创建于">{{ $post->created_at->format('Y-m-d H:i') }}</span> /
                                    <span aria-hidden="true" class="glyphicon glyphicon-eye-open" title="查看数"></span>
                                    <span title="阅读数">{{ visits($post)->count() }}</span>&nbsp;/
                                    <span title="评论数"><i class="fa fa-commenting-o" aria-hidden="true"></i> {{ $post->comments->count()}}</span>
                                    @can('update', $post)
                                        <span class="pull-right">
                                        <a href="/posts/{{$post->slug}}/edit">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                        <span style="font-size: 12px">编辑</span>
                                    </a>
                                    <a href="javascript:;" onclick="deletePost({{ $post->id }})">
                                        <span class="glyphicon glyphicon-remove"></span>
                                        <span style="font-size: 12px">删除</span>
                                    </a>
                                    </span>
                                    @endcan
                                </div>
                            </div>
                            <div v-if="signedIn">
                            </div>
                        </div>
                    </div>

                    <div class="panel-body" style="margin-right: 30px; margin-left: 30px">
                        {!! $post->body !!}
                    </div>

                    <div class="praise-box">
                        <zan :post_id="{{ $post->id }}"></zan>
                    </div>
                </div>
                <div class="bl-comment">
                    <h4 class="bl-title" style="margin-left: 10px">相关评论</h4>
                    @if (count($comments) != 0)
                        @if(!Auth::guest())
                            <comment-post :user_id="{{\Auth::id()}}" :comments="{{$comments}}"
                                          :post_id="{{$post->id}}"
                                          :collections="{{$comments[0]}}"></comment-post>
                        @else
                            <comment-post :user_id="0" :comments="{{$comments}}" :post_id="{{$post->id}}"
                                          :collections="{{$comments[0]}}"></comment-post>
                        @endif

                    @else
                        <comment-post :user_id="0" :comments="{{$comments}}" :post_id="{{$post->id}}"
                                      :collections="{{$comments}}"></comment-post>
                    @endif

                </div>

            </div>
            @include('posts.partials._right')
        </div>
    </div>
@endsection

@section('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('js/vendor/prism.js') }}"></script>
    <script>
        function deletePost(post) {
            swal({
                title: '你确定要删除"{{ $post->title }}"这篇文章吗?',
                text: "一但删除，将不能恢复！",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = '/posts/' + post + '/delete';
                        swal('文章"{{ $post->title }}已被删除！"', {
                            icon: "success",
                        });
                    }
                });
        }
    </script>
@endsection
