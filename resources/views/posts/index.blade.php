@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12">

                @include('layouts.partials._email_alert')

                @forelse($posts as $post)
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding: 4px;">
                        <div class="level">
                            <div class="flex">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="{{ route('profile', $post->creator->slug) }}" title="{{ $post->creator->name }}">
                                            <img class="media-object img-circle" width="40px" src="{{ $post->creator->avatar_path }}" alt="{{ $post->creator->name }}">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <h4><a href="{{ url('/posts/' . $post->slug) }}">{{ $post->title }}</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="body">{!! str_limit($post->body, 420, '...') !!}</div>
                    </div>

                    <div class="panel-footer" style="padding: 3px;background-color: #ffffaa">
                        <span aria-hidden="true" class="glyphicon glyphicon-eye-open"></span>
                        <span title="阅读数">{{ visits($post)->count() }}</span>&nbsp;
                        <span title="喜欢数"><i class="fa fa-heart-o" aria-hidden="true"></i> 156</span>&nbsp;
                        <span title="点赞数"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 156</span>&nbsp;
                        <span title="评论数"><i class="fa fa-commenting-o" aria-hidden="true"></i> 2</span>&nbsp;
                        @if($post->category)
                        <span title="分类"><i class="fa fa-list" aria-hidden="true"></i> <a href="">{{ $post->category->name }}</a></span>&nbsp;
                        @endif
                        @if(count($post->topics))
                        <span title="专题"><i class="fa fa-tags" aria-hidden="true"></i>
                            @foreach($post->topics as $topic)
                            <a href="">\ {{ $topic->name }}</a>
                            @endforeach
                        </span>
                        @endif
                        <span aria-hidden="true" class="glyphicon glyphicon-time"></span>
                        <span title="创建于">{{ $post->created_at->diffForHumans()}}</span>

                    </div>
                </div>
                    @empty
                    <p>没有文章！</p>
                @endforelse

                {{ $posts->links() }}
            </div>

            @include('posts.partials._right')
        </div>
    </div>
@endsection