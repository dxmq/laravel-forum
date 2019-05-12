@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include ('threads._list')

                {{ $threads->render() }}
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Trending Threads
                    </div>

                    <div class="panel-body">
                        something here.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection