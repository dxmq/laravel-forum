@if($model->comments->count() < 1)
    <div class="alert alert-warning">说些什么吧...</div>
@endif

<ul class="list-unstyled">
    @foreach($model->comments->where('parent', null) as $comment)
        @include('comments::_comment')
    @endforeach
</ul>

@auth
    @include('comments::_form')
@else
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">权限要求</h5>
            <p class="card-text">你必须先登录</p>
            <a href="{{ route('login') }}" class="btn btn-primary">登录</a>
        </div>
    </div>
@endauth
