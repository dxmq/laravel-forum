@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2">
                <div class="page-header">
                    @if ($profileUser->avatar_path)
                        <form action="">

                        <h1 v-text="user.name"></h1>
                        <hr>
                        <img src="{{ $defaultAvatar }}" alt="avatar">

                        <input type="file">
                        </form>
                    @else
                        <avatar-form :user="{{ $profileUser }}"></avatar-form>
                    @endif
                </div>

                @forelse($activities as $date => $activity)
                    <h3 class="page-header">{{ $date }}</h3>

                    @foreach($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include("profiles.activities.{$record->type}",['activity'  => $record])
                        @endif
                    @endforeach
                @empty
                    <p>{{ $profileUser->name }} 仍然没有任何活动。</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection