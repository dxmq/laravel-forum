@component('profiles.activities.activity')
    @slot('heading')

        @if($record->causer->id == auth()->id())你@else Ta @endif对
        @if(get_class($record->subject->favorited) == 'App\Reply')
            回复...
            <a href="{{ $record->subject->favorited->path() }}">
                点赞 <span class="glyphicon glyphicon-heart"></span>
            </a>
        @else
            文章
            <a href="{{ url('/posts', [$record->subject->favorited->slug]) }}">
                {{ $record->subject->favorited->title }}
            </a>
            点赞 <span class="glyphicon glyphicon-heart"></span>
        @endif
    @endslot
@endcomponent