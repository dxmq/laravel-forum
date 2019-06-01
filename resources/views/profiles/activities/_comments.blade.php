@component('profiles.activities.activity')
    @slot('heading')
        @if($record->causer->id == auth()->id())你@else Ta @endif在文章 <a href="{{ url('/posts', [ $record->subject->commentable->slug]) }}">{{ $record->subject->commentable->title }}
        </a>
        {{ $record->description }}...
    @endslot
@endcomponent