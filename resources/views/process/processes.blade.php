<div class="clearfix">
</div>
<div class="panel panel-default clearfix">
    <div class="panel-heading clearfix">
        <div class="pull-left">{{$team->name}}</div>
        @if ($team->pivot->role->permissions->where('slug', 'create.process')->isNotEmpty())
        <a class="btn btn-primary pull-right" href="{{route('process_create', [$team->id])}}">New process</a>
        @endif
    </div>
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
                        @if ($team->pivot->role->permissions->where('slug', 'create.process')->isNotEmpty())
                            <a href="{{ route('process.edit', [$process->id]) }}">{{$process->identifier}}</a>
                        @else
                            {{$process->identifier}}
                        @endif
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