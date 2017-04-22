@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="clearfix">
            </div>
            <div class="panel panel-default clearfix">
                @if (head(array_where($permissions, function($value, $key) { return $value->slug == 'create.process'; })))
                <div class="panel-heading clearfix">
                    <a class="btn btn-primary pull-right" href="/process/create">New process</a>
                </div>
                @endif
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Identifier</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($processes as $process)
                            <tr class="process-row">
                                <td>
                                    @if (head(array_where($permissions, function($value, $key) { return $value->slug == 'create.process'; })))
                                        <a href="{{ route('process.edit', [$process->id]) }}">{{$process->identifier}}</a>
                                    @else
                                        {{$process->identifier}}
                                    @endif
                                </td>
                                <td class="process-status">{{$process->status}}</td>
                                <td class="process-action">
                                    <div class="btn-group pull-right">
                                        @if (head(array_where($permissions, function($value, $key) { return $value->slug == 'create.process'; })))
                                            @if ($process->canStart())
                                            <button type="button"
                                                class="btn btn-default toggle-drop start"
                                                onclick="startProcess('{{action('ProcessController@start', [$process->id])}}')">
                                                Start
                                            </button>
                                            @elseif ($process->canStopOrRestart())
                                            <button type="button" 
                                                class="btn btn-default toggle-drop restart"
                                                onclick="restartProcess('{{action('ProcessController@reload', [$process->id])}}')">
                                                Restart
                                            </button>
                                            <button type="button" 
                                                class="btn btn-default toggle-drop stop"
                                                onclick="stopProcess('{{action('ProcessController@stop', [$process->id])}}')">
                                                Stop
                                            </button>
                                            @endif
                                            <button type="button" 
                                                class="btn btn-default toggle-drop log"
                                                onclick="readProcessLog('{{action('ProcessLogController@log', [$process->id])}}')">
                                                Log
                                            </button>
                                            <button type="button"
                                                class="btn btn-default dropdown-toggle" 
                                                data-toggle="dropdown">
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu"
                                                aria-labelledby="process-menu-{{$process->id}}">
                                                <li><a href="javascript:reload_process({{action('ProcessController@restart', [$process->id])}});">Gracefull restart</a></li>
                                                <li>
                                                    <a href="javascript:delete_process('{{route('process.destroy', [$process->id])}}');">Delete</a>
                                                </li>
                                            </ul>
                                        @else
                                        <button type="button" 
                                            class="btn btn-default toggle-drop log"
                                            onclick="readProcessLog('{{action('ProcessLogController@log', [$process->id])}}')">
                                            Log
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function delete_process(deleteProcessUrl)
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.post(deleteProcessUrl, {"_method": "DELETE"})
        .done(function(res) {
            console.log(res)
        })
}

function startProcess(startProcessUrl)
{
    $.get(startProcessUrl).done(function(res) {
        document.location.reload();
    })
}

function reloadProcess(reloadProcessUrl)
{
    $.get(reloadProcessUrl).done(function(res) {
        document.location.reload();
    })
}

function restartProcess(restartProcessUrl)
{
    $.get(restartProcessUrl).done(function(res) {
        document.location.reload();
    })
}

function stopProcess(stopProcessUrl)
{
    $.get(stopProcessUrl).done(function(res) {
        document.location.reload();
    })
}

function readProcessLog(readProcessLogUrl) {
    document.location.href = readProcessLogUrl;
}
</script>
@endsection
