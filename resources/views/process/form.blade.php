            <div class="form-group">
                <label for="identifier">Process ID</label>
                <input class="form-control" name="identifier" value="{{$process->identifier}}"></input>
            </div>
            <div class="form-group">
                <label for="deploy_type">Deploy type</label>
                <select class="form-control" name="deploy" id="deploy">
                    <option value="command">Command</option>
                    <option value="code">Code</option>
                    <option value="zip">ZIP</option>
                </select>
            </div>
            <div class="form-group deploy_command">
                <label for="code">Command</label>
                <textarea class="form-control" name="command" placeholder="nginx">{{$process->command}}</textarea>
            </div>
            <div class="form-group deploy_code" style="display: none">
                <label for="code">Code</label>
                <textarea class="form-control" name="code">{{$process->code}}</textarea>
            </div>
            <div class="form-group">
                <label for="process_number">Process number</label>
                <input class="form-control" type="text" name="process_number" value="{{$process->process_number}}"></input>
            </div>
            <button type="submit" class="btn btn-primary pull-right">Publish new process</button>
            {{ csrf_field() }}
            {{$slot}}

            <script>
$(document.body).ready(function() {
    var process =
    @php
    echo json_encode($process);
    @endphp
    

    $("#deploy").val(process.deploy.toLowerCase());
    var deploy = ['command', 'code'];
    for (var i = 0, size = deploy.length; i < size; i++) {
        var d = deploy[i];
        var commandElement = $(".deploy_" . d);

        if (d == process.command)
            commandElement.css("display", "block");
        else
            commandElement.css("display", "none");
    }
    
})
</script>