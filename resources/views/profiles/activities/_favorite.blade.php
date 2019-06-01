@component('profiles.activities.activity')
    @slot('heading')
        @if($record->causer->id == auth()->id())你@else Ta @endif对回复....
        <a href="{{ $record->subject->favorited->path() }}">
            <span class="glyphicon glyphicon-heart"></span>点赞
        </a>
    @endslot
@endcomponent