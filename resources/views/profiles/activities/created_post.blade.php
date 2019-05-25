@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} 发表了
        <a href="{{ url('/posts', [$activity->subject->slug])}}">{{ $activity->subject->title }}</a>
    @endslot
    @slot('body')
        {!! str_limit($activity->subject->body, 200) !!}
    @endslot
@endcomponent