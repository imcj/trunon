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
                    <a class="btn btn-primary pull-right" href="/process/create">启动新进程</a>
                </div>
                @endif
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Identifier</th>
                                <th>状态</th>
                                <th>操作</th>
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
                                    <p>{{$process->description}}</p>
                                </td>
                                <td class="process-status">{{$process->status}}</td>
                                <td class="process-action">
                                    <div class="btn-group pull-right">
                                        @if (head(array_where($permissions, function($value, $key) { return $value->slug == 'create.process'; })))
                                            @if ($process->canStart())
                                            <button type="button"
                                                class="btn btn-default toggle-drop start"
                                                onclick="startProcess('{{action('ProcessController@start', [$process->id])}}')">
                                                启动
                                            </button>
                                            @elseif ($process->canStopOrRestart())
                                            <button type="button" 
                                                class="btn btn-default toggle-drop restart"
                                                onclick="restartProcess('{{action('ProcessController@reload', [$process->id])}}')">
                                                重启
                                            </button>
                                            <button type="button" 
                                                class="btn btn-default toggle-drop stop"
                                                onclick="stopProcess('{{action('ProcessController@stop', [$process->id])}}')">
                                                停止
                                            </button>
                                            @endif
                                            <button type="button" 
                                                class="btn btn-default toggle-drop log"
                                                onclick="readProcessLog('{{action('ProcessLogController@log', [$process->id])}}')">
                                                查看日志
                                            </button>
                                            <button type="button"
                                                class="btn btn-default dropdown-toggle" 
                                                data-toggle="dropdown">
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu"
                                                aria-labelledby="process-menu-{{$process->id}}">
                                                @if (head(array_where($permissions, function($value, $key) { return $value->slug == 'create.process'; })) && $process->canStopOrRestart())
                                                <li><a href="javascript:reload_process({{action('ProcessController@restart', [$process->id])}});">平滑重启</a></li>
                                                @endif
                                                <li>
                                                    <a href="javascript:delete_process('{{route('process.destroy', [$process->id])}}');">删除</a>
                                                </li>
                                            </ul>
                                        @else
                                        <button type="button" 
                                            class="btn btn-default toggle-drop log"
                                            onclick="readProcessLog('{{action('ProcessLogController@log', [$process->id])}}')">
                                            查看日志
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
