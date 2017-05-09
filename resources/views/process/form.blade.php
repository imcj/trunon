            <div class="form-group">
                <label for="identifier">进程ID</label>
                <input class="form-control" name="identifier" value="{{$process->identifier}}"></input>
            </div>
            <div class="form-group">
                <label for="deploy_type">部署类型</label>
                <select class="form-control" name="deploy" id="deploy">
                    <option value="command">Command</option>
                    <option value="code">Code</option>
                    <option value="zip">ZIP</option>
                </select>
            </div>
            <div class="form-group deploy_command">
                <label for="code">命令行</label>
                <textarea class="form-control" name="command" placeholder="nginx">{{$process->command}}</textarea>
            </div>
            <div class="form-group deploy_code" stype="display: none;">
                <label for="code">Shell脚本</label>
                <textarea class="form-control" name="code">{{$process->code}}</textarea>
            </div>
            <div class="form-group">
                <label for="process_number">进程数量</label>
                <input class="form-control" type="text" name="process_number" value="{{$process->process_number}}"></input>
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