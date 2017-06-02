            <div class="form-group{{ $errors->has('identifier') ? ' has-error' : '' }}">
                <label for="identifier">进程ID</label>
                <input class="form-control" name="identifier" value="{{old('identifier') == '' ? $process->identifier : old('identifier')}}" {{$process->id > 0?"disabled=\"disabled\"":""}}></input>

                @if ($errors->has('identifier'))
                    <span class="help-block">
                        <strong>{{ $errors->first('identifier') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="deploy_type">部署类型</label>
                <select class="form-control" name="deploy" id="deploy">
                    <option value="command">Command</option>
                    <option value="code">Code</option>
                    <option value="zip">ZIP</option>
                </select>
            </div>
            <div class="form-group deploy_command{{ $errors->has('deploy_command') ? ' has-error' : '' }}">
                <label for="code">命令行</label>
                <textarea class="form-control" name="command" placeholder="nginx">{{old('command') == '' ? $process->command : old('command')}}</textarea>
                @if ($errors->has('deploy_command'))
                    <span class="help-block">
                        <strong>{{ $errors->first('deploy_command') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group deploy_code deploy_command{{ $errors->has('deploy_code') ? ' has-error' : '' }}" stype="display: none;">
                <label for="code">Shell脚本</label>
                <textarea class="form-control" name="code">{{old('deploy_command') == '' ? $process->code : old('deploy_command')}}</textarea>
                @if ($errors->has('deploy_code'))
                <span class="help-block">
                        <strong>{{ $errors->first('deploy_code') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="process_number">进程数量</label>
                <input class="form-control" type="text" name="process_number" value="{{$process->process_number}}"></input>
            </div>
            <div class="form-group">
                <label for="process_number">进程目录</label>
                <input class="form-control" type="text" name="root_directory" value="{{$process->root_directory}}"></input>
            </div>
            <div class="form-group{{ $errors->has('environment') ? ' has-error' : '' }}">
                <label for="environment">环境变量</label>
                <input class="form-control" type="text" name="environment" value="{{$process->environment}}"></input>
                @if ($errors->has('environment'))
                    <span class="help-block">
                        <strong>{{ $errors->first('environment') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                <label for="code">描述</label>
                <textarea class="form-control" name="description">{{old('description') == '' ? $process->description : old('description')}}</textarea>
                @if ($errors->has('description'))
                <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary pull-right">发布进程</button>
            {{ csrf_field() }}
            {{$slot}}

            <script>

function activeDeploy(activeType)
{
    var deploy = ['command', 'code'];
    for (var i = 0, size = deploy.length; i < size; i++) {
        var type = deploy[i];
        var commandElement = $(".deploy_" + type);
        var className = ".deploy_" + type
        if (type == activeType)
            $(className).css("display", "block");
        else
            $(className).css("display", "none");
    }
}

$(document.body).ready(function() {
    var process =
    @php
    echo json_encode($process);
    @endphp
    
    $("#deploy").change(function(event) {
        var currentDeployType = $(event.currentTarget).val()
        activeDeploy(currentDeployType)
    })
    activeDeploy(process.deploy.toLowerCase())
    $("#deploy").val(process.deploy.toLowerCase())
})
</script>