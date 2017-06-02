<div class="clearfix">
</div>
<div class="panel panel-default clearfix">
    <div class="panel-heading clearfix">
        <div class="pull-left">{{$team->name}}</div>
        @if ($team->pivot->role->permissions->where('slug', 'create.process')->isNotEmpty())
        <a class="btn btn-primary pull-right" href="{{route('process_create', [$team->id])}}">启动新进程</a>
        @endif
    </div>
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
                        @if ($team->pivot->role->permissions->where('slug', 'create.process')->isNotEmpty())
                            <a href="{{ route('process.edit', [$process->id]) }}">{{$process->identifier}}</a>
                        @else
                            {{$process->identifier}}
                        @endif
                        <p>{{$process->description}}</p>
                    </td>
                    <td class="process-status">
                        @if ($process != null)
                        {{$process->supervisorStatus()}}
                        @endif
                    </td>
                    <td class="process-action">
                        <div class="btn-group pull-right">
                            @if ($team->pivot->role->permissions->where('slug', 'create.process')->isNotEmpty())
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
                                    <li><a href="javascript:reload_process({{action('ProcessController@restart', [$process->id])}});">平滑重启</a></li>
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