@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        @foreach ($teams as $team)
            @component('process/processes', ['processes' => $team->process, 'team' => $team])    
            @endcomponent
        @endforeach
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
