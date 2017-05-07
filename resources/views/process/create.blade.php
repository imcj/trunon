@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="{{route('process.index')}}">Process</a></li>
                <li class="active">Add</li>
            </ol>
            <form action="{{route('process_store', [$teamId])}}" method="POST" enctype="application/x-www-form-urlencoded">
                @component("process.form", ["process" => $process]) @endcomponent
            </form>
        </div>
    </div>
</div>

@endsection
