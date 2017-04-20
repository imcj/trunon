<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Deploy;
use App\Core\SupervisordRPCFactory;
use App\Model\Process;
use App\Model\Team;
use App\Http\Services\ProcessService;
use Supervisor\Api;

class ProcessLogController
{
    private $supervisordRpc;

    public function __construct()
    {
        $supervisordRPCFactory = new SupervisordRPCFactory();
        $this->supervisordRpc = $supervisordRPCFactory->create();
    }

    public function log($id)
    {
        $process = Process::find($id);
        $rsp = $this->supervisordRpc->tailProcessStdoutLog(
            $process->identifier,
            0,
            10240
        );

        return view('process/log', [
            "log" => $rsp[0],
            "process" => $process
        ]);
    }

    public function stdout($id)
    {
        $process = Process::find($id);
        $rsp = $this->supervisordRpc->tailProcessStdoutLog(
            $process->identifier,
            0,
            10240
        );
        return response($rsp[0]);
    }

    public function stderr($id)
    {
        $process = Process::find($id);
        $rsp = $this->supervisordRpc->tailProcessStderrLog(
            $process->identifier,
            0,
            10240
        );
        return response($rsp[0]);
    }
}