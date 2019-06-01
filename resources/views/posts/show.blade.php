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
                                    <span title="评论数"><i class="fa fa-commenting-o"
                                                         aria-hidden="true"></i> {{ $post->comments->count()}}</span>
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


                    <div class="panel-body">
                        {!! $post->body !!}
                    </div>

                    <div class="praise-box">
                        <zan :post="{{ $post }}"></zan>
                    </div>

                    <div class="panel-footer">
                        @if (!empty($previousPost))
                            <span title="{{ $previousPost->title }}"><a
                                        href="{{ route('posts.show', $previousPost->slug) }}"><span class="fa fa-reply"></span>上一篇</a>
                        </span>
                        @else
                            <span class="fa fa-info"></span>
                            <span>
                                已经是第一篇了
                            </span>
                        @endif
                        @if (!empty($nextPost))
                        <span class="pull-right" title="{{ $nextPost->title }}"><a
                                    href="{{ route('posts.show', $nextPost->slug) }}"><span class="fa fa-share"></span>下一篇</a></span>
                            @else
                            <div class="pull-right">
                                <span class="fa fa-info"></span>
                                <span>
                                已经是最后一篇了
                            </span>
                            </div>
                        @endif
                    </div>
                </div>
                @comments(['model' => $post])
                @endcomments

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
