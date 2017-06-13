@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="{{route('ssh.index')}}">SSH Keys</a></li>
            </ol>
            <form action="{{ route("ssh.store") }}" method="POST" enctype="application/x-www-form-urlencoded">
                <div class="form-group{{ $errors->has('private_key') ? ' has-error' : '' }}">
                    <label for="private_key">私有Key</label>
                    <textarea class="form-control" name="private_key" rows="10">{{old('private_key')}}</textarea>

                    @if ($errors->has('private_key'))
                        <span class="help-block">
                            <strong>{{ $errors->first('private_key') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="public_key">公开Key</label>
                    <textarea class="form-control" name="public_key">{{old('public_key')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="title">标题</label>
                    <textarea class="form-control" name="title">{{old('title')}}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary pull-right">添加</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
