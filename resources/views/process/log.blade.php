@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="{{route('process.index')}}">Process</a></li>
                <li class="active">Log</li>
            </ol>
            <div class="panel panel-default">
                <div class="panel-body">
                    <!-- Nav tabs -->
                    <ul id="stdtab" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#stdout"  data-pipe="stdout" aria-controls="stdout" role="tab" data-toggle="tab">Stdout</a></li>
                        <li role="presentation"><a href="#stderr" data-pipe="stderr" aria-controls="stderr" role="tab" data-toggle="tab">Stderr</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="stdout">
                            <pre>{{$log}}</pre>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="stderr">
                            <pre></pre>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<script>

$('#stdtab a').click(function (e) {
  e.preventDefault()
  $pipe = $(e.target).attr("data-pipe")
  var stdout = "{{action('ProcessLogController@stdout', [$process->id])}}";
  var stderr = "{{action('ProcessLogController@stderr', [$process->id])}}";

  if ($pipe == "stderr") {
      $.get(stderr).done(function(rsp) {
        $("#" + $pipe + " pre").html(rsp)
      })
  }
//   $(this).tab('show')
})
</script>
@endsection
