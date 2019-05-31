@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">创建一个新的话题</div>

                    <div class="panel-body">
                        <form method="post" action="/threads">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="channel_id">选择一个频道</label>
                                <select name="channel_id" id="channel_id" class="form-control" required>
                                    <option value="">选择一个...</option>
                                    @if(! empty($channels))
                                        @foreach($channels as $channel)
                                            <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : ''}}>
                                                {{ $channel->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">标题</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{ old('title') }}">
                            </div>

                            <div class="form-group">
                                <label for="body">内容</label>
                                <wysiwyg name="body"></wysiwyg>
                            </div>

                            <button type="submit" class="btn btn-primary">Publish</button>

                            @include('layouts.partials.error')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection