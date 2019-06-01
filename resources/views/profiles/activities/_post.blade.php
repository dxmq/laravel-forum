@component('profiles.activities.activity')
    @slot('heading')
        @if($record->causer->id == auth()->id())你@else Ta @endif{{ $record->description }}
        <a href="{{ url('/posts', [ $record->subject->slug]) }}">{{ $record->subject->title }}</a>
    @endslot
@endcomponent