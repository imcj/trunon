@extends('layouts.app')

@section('content')
<div class="container notification">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ol class="breadcrumb">
                <li><a href="/home">首页</a></li>
                <li><a href="{{ url('notifications') }}">通知</a></li>
                <li class="active">{{ $notification->subject }}</li>
            </ol>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $notification->subject }}</h3>
                </div>
                <div class="panel-body notification-panel">
                    {{ $notification->content }}
                    <p>{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
