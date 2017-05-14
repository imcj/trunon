<?php
namespace App\Core\Supervisor;


use App\Model\Process;

class Path
{
    /**
     * @var string
     */
    private $workspaceDir;

    /**
     * @var Process
     */
    private $process;

    public function __construct($workspaceDir, Process $process)
    {
        $this->workspaceDir = $workspaceDir;
        $this->process = $process;
    }

    public function workspaceDir()
    {
        return $this->workspaceDir;
    }

    public function processExecutePath()
    {
        if ($this->process->deploy == strtolower(Process::DEPLOY_CODE)) {
            return $this->processDir($this->process) .
                "/{$this->process->identifier}";
        }

        throw new \Exception("Process deploy mode is not code.");
    }

    public function processDir($process)
    {
        if (null != $process->root_directory ||
            "" != $process->root_directory) {
            return $process->root_directory;
        }
        return "{$this->workspaceDir}/process/" .
            "{$process->identifier}";
    }


    public function processLogDir()
    {
        return "{$this->workspaceDir}/process/" .
            "{$this->process->identifier}/log";
    }

    public function supervisordConfigFilePath($process)
    {
        return "{$this->workspaceDir}/conf.d" .
            "/{$process->identifier}.conf";
    }
}