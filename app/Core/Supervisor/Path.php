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

    public function processDir()
    {
        if (null != $this->process->root_directory ||
            "" != $this->process->root_directory) {
            return $this->process->root_directory;
        }
        return "{$this->workspaceDir}/process/" .
            "{$this->process->identifier}";
    }


    public function processLogDir()
    {
        return "{$this->workspaceDir}/process/" .
            "{$this->process->identifier}/log";
    }

    public function supervisordConfigFilePath()
    {
        return "{$this->workspaceDir}/conf.d" .
            "/{$this->process->identifier}.conf";
    }
}