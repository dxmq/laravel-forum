@extends('layouts.app')

@section('title', '首页')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/vendor/aos.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-9">

                @include('layouts.partials._email_alert')

                @if(! empty($category))
                    @if($posts->count())
                        <div class="alert alert-success alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            分类为 "{{ $category }}" 下的文章有：
                        </div>
                    @else
                        <div class="alert alert-warning alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            没有分类为 "{{ $category }}" 的文章！
                        </div>
                    @endif
                @endif

                @if (! empty($topic))
                    @if($posts->count())
                        <div class="alert alert-success alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            专题为 "{{ $topic }}" 下的文章有：
                        </div>
                    @else
                        <div class="alert alert-warning alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            没有专题为 "{{ $topic }}" 的文章！
                        </div>
                    @endif
                @endif
                <div class="infinite-scroll">
                    @foreach($posts as $post)
                        <div class="panel panel-default" data-aos="fade-up" data-aos-easing="ease-in-sine">
                            <div class="panel-heading" style="padding: 4px;">
                                <div class="level">
                                    <div class="flex">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="{{ route('profile', $post->creator->slug) }}"
                                                   title="{{ $post->creator->name }}">
                                                    <img class="media-object img-thumbnail" width="40px"
                                                         src="{{ $post->creator->avatar_path }}"
                                                         alt="{{ $post->creator->name }}">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4>
                                                    <a href="{{ url('/posts/' . $post->slug) }}">{{ $post->title }}</a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="body">{!! str_limit($post->body, 420, '...') !!}</div>
                            </div>

                            <div class="panel-footer" style="padding: 4px; background-color: #ffffff">
                            <span title="评论数"><i class="fa fa-commenting-o"
                                                 aria-hidden="true"></i> {{ $post->comments()->count() }}</span>&nbsp;
                                <span title="点赞数"><i class="fa fa-thumbs-o-up"
                                                     aria-hidden="true"></i> {{ $post->favorites()->count() }}</span>&nbsp;
                                <span aria-hidden="true" class="glyphicon glyphicon-eye-open"></span>
                                <span title="阅读数">{{ visits($post)->count() }}</span>&nbsp;
                                @if($post->category)
                                    <span title="分类"><i class="fa fa-list" aria-hidden="true"></i> <a
                                                href="{{ url('/posts/categories/' . $post->category_id) }}">{{ $post->category->name }}</a></span>
                                    &nbsp;
                                @endif
                                @if(count($post->topics))
                                    <span title="专题"><i class="fa fa-tags" aria-hidden="true"></i>
                                        @foreach($post->topics as $topic)
                                            <a href="{{ url('/posts/topics', [$topic->id]) }}">\ {{ $topic->name }}</a>
                                        @endforeach
                        </span>
                                @endif
                                <span aria-hidden="true" class="glyphicon glyphicon-time"></span>
                                <span title="创建于">{{ $post->created_at->diffForHumans() }}</span>

                            </div>
                        </div>
                    @endforeach
                    <div>
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>

            @include('posts.partials._right')
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/vendor/aos.js') }}"></script>
    <script>
        $(function () {
            AOS.init({
                disable: 'mobile',
            }); // 加载动画
        });
    </script>
@endsection