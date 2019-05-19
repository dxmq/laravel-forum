@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <div class="flex">
                                <div class="media-left">
                                    <a href="{{ route('profile', $post->creator->slug) }}" title="{{ $post->creator->name }}">
                                        <img class="media-object" width="35px" src="{{ $post->creator->avatar_path }}" alt="{{ $post->creator->name }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4>{{ $post->title }}</h4>
                                </div>
                                <div class="media-bottom">
                                    <span title="创建于">{{ $post->created_at->format('Y-m-d H:i') }}</span> /
                                    <span aria-hidden="true" class="glyphicon glyphicon-eye-open" title="查看数"></span>
                                    <span title="阅读数">{{ visits($post)->count() }}</span>&nbsp;/
                                    <span title="评论数"><i class="fa fa-commenting-o" aria-hidden="true"></i> 2</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="body">{!! $post->body !!}</div>
                    </div>

                    <div class="comment">
                        <h4 class="bl-title">相关评价</h4>
                        <form class="bl-comment-form">
                            <div class="form-group">
                                <textarea class="form-control" placeholder="想说就说吧..." id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>
                            <button type="button">发表</button>
                            <span class="clearfix"></span>
                        </form>

                        <div class="comment-panel">
                            <div class="comment-panel-portrait"><img src="img/portrait.jpg" alt=""></div>
                            <div class="comment-panel-content">
                                <div class="comment-panel-content-item">
                                    <span>海哥</span>
                                    <span>2017-10-01 18:00</span>
                                </div>
                                <p>我上传的是FTP，怎么安装？</p>
                            </div>
                            <span class="clearfix"></span>
                            <p class="bl-reply"><a href="">回复</a></p>
                        </div>
                        <div class="comment-panel">
                            <div class="comment-panel-portrait"><img src="img/portrait.jpg" alt=""></div>
                            <div class="comment-panel-content">
                                <div class="comment-panel-content-item">
                                    <span>海哥</span>
                                    <span>2017-10-01 18:00</span>
                                </div>
                                <div class="comment-panel-secondary">
                                    <span>引用来自于 <span>你要走到那里去</span> 的内容</span>
                                    <p>稍等，我看看</p>
                                </div>
                                <p>我上传的是FTP，怎么安装？</p>
                            </div>
                            <span class="clearfix"></span>
                            <p class="bl-reply"><a href="">回复</a></p>
                        </div>
                    </div>
                </div>

            </div>
            @include('posts.partials._right')
        </div>
    </div>
@endsection