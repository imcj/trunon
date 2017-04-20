@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="{{route('process.index')}}">Process</a></li>
                <li class="active">Edit</li>
            </ol>
            <form action="{{ route("process.update", [$process->id]) }}" method="POST" enctype="application/x-www-form-urlencoded">
            <div class="form-group">
                <label for="identifier">Process ID</label>
                <input class="form-control" name="identifier" value="{{$process->identifier}}" disabled></input>
            </div>
            <div class="form-group">
                <label for="deploy_type">Deploy type</label>
                <select class="form-control" name="deploy">
                    <option value="code">Code</option>
                    <option value="zip">ZIP</option>
                </select>
            </div>
            <div class="form-group">
                <label for="code">Code</label>
                <textarea class="form-control" name="code">{{$process->code}}</textarea>
            </div>
            <div class="form-group">
                <label for="process_number">Process number</label>
                <input class="form-control" type="text" name="process_number" value="{{$process->process_number}}"></input>
            </div>
            <button type="submit" class="btn btn-primary pull-right">Publish process</button>
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            </form>
        </div>
    </div>
</div>
@endsection
