@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }}
        <a href="{{ $activity->subject->favorited->path() }}">
             对下面的回复进行了点赞
        </a>
    @endslot
    @slot('body')
        {!! $activity->subject->favorited->body  !!}
    @endslot
@endcomponent