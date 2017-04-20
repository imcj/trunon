@extends('layouts.app')

@section('content')
<div class="container notification">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>通知</h1>
            <div class="panel panel-default">
                <div class="panel-body notification-panel">
                    <table class="table">
                        <thead>
                          <tr>
                            <th class="type">Type</th>
                            <th>Subject</th>
                            <th class="created_at">Date</th>
                          </tr>
                        </thead>
                        @foreach ($notifications as $notification)
                        <tr class="{{ $notification->unreadCssClassActive() }}">
                            <td>
                            <span class="glyphicon {{ $notification->cssClassType() }}"></span>
                            </td>
                            <td class="subject">
                                <p><a href="{{ url('notifications', [$notification->id()]) }}">{{ $notification->subject() }}</a></p>
                                <p class="summary">{{ $notification->content() }}</p>
                            </td>
                            <td>{{ $notification->createdAt() }}</td>
                        </tr>
                        @endforeach
                    </table>
                    <div class="center-block">
                        {{ $paginator }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
