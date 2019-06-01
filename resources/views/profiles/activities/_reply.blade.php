@component('profiles.activities.activity')
    @slot('heading')
        @if($record->causer->id == auth()->id())你@else Ta @endif在话题
        <a href="{{ $record->subject->thread->path() }}">{{ $record->subject->thread->title }}</a>
        回复了....
    @endslot
@endcomponent