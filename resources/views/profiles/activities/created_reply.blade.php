@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} 回复了
        <a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent