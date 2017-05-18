<?php
namespace App\Core;


use App\Core\Supervisor\Path;
use App\Core\Supervisor\Program;
use App\Model\Process;

class Translater
{
    /**
     * @param Path $path
     * @param Process $process
     * @return Program
     */
    public function toSupervisor(Path $path, Process $process)
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
                $command = $path->processExecutePath();
                break;
        }

        $program = new Program(
            $process->identifier,
            $command,
            $process->processNumber,
            $path->processLogDir() . "/stdout.log",
            $path->processLogDir() . "/stderr.log",
            $directory
        );

        return $program;
    }
}