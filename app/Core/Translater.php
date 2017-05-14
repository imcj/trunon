<?php
namespace App\Core;


use App\Core\Supervisor\Program;
use App\Model\Process;

class Translater
{
    public function toSupervisor(Process $process)
    {
        if (null != $process->root_directory && "" != $process->root_directory) {
            $directory = $process->root_directory;
        } else {
            $directory = "";
        }

        $command = "";
        switch (strtoupper($process->deploy)) {
            case Process::DEPLOY_COMMAND:
                $command = $process->command;
                break;
            case Process::DEPLOY_CODE:
                $command = $processExecutePath;
                break;
        }

        $program = new Program(
            $process->identifier,
            $command,
            $process->processNumber,
            $stdoutFile,
            $stderrFile,
            $directory
        );
    }
}