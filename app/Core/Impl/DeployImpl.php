<?php
namespace App\Core\Impl;

use App\Core\Deploy;
use App\Core\Supervisor\Path;
use App\Core\Translater;
use App\Model\Process;
use \Supervisor\Api;
use \Supervisor\ApiException;
use Log;

/**
 *
 */
class DeployImpl implements Deploy
{
    /**
     * @var string
     */
    private $workspaceDir;

    /**
     * @var Process
     */
    private $process;

    private $supervisordRpc;

    public function __construct(
        $workspaceDir,
        Api $supervisordRpc)
    {
        $this->workspaceDir = $workspaceDir;
        $this->supervisordRpc = $supervisordRpc;
    }

    public function remove($process)
    {
        $path = new Path($this->workspaceDir, $process);

        try {
            $this->supervisordRpc->stopProcess($process->identifier);
        } catch(ApiException $exception) {
            Log::info($exception->getMessage());
        }
        Log::info("Delete " . $path->supervisordConfigFilePath($process));
        Log::info("Delete " . $path->processDir($process));
        @unlink($path->supervisordConfigFilePath($process));
        // TODO: 用PHP方法实现
        system("rm -rf " . $path->processDir($process));
        // rmdir($this->processDir());
    }

    /**
     * 部署进程执行代码到 workspace 目录中。
     *
     *
     * @param $process
     * @return void
     */
    public function do(Process $process)
    {
        $this->deployProcess($process);
        $this->deploySupervisordProcessConfigFile($process);
        $this->reloadSupervisorConfig();
    }

    function deployProcess($process)
    {
        Log::info("部署进程 类型:{$process->deploy}");
        $path = new Path($this->workspaceDir, $process);
        $processDir = $path->processDir();
        if ($process->deploy == strtolower(Process::DEPLOY_CODE)) {
            $processExecutePath = $path->processExecutePath();

            Log::info("部署源代码到 {$processDir}");
            if (!file_exists($processDir))
                mkdir($processDir, 0755, true);
            $fd = fopen($processExecutePath, "w");
            $code = str_replace("\r\n", "\n", $process->code);
            fwrite($fd, $code);
            fclose($fd);
            chmod($processExecutePath, 0755);
        }

        @mkdir($processDir . "/log", 0755, true);
    }

    function deploySupervisordProcessConfigFile($process)
    {
        $path = new Path($this->workspaceDir, $process);
        $translater = new Translater();

        $fd = fopen($path->supervisordConfigFilePath(), "w");
        $program = $translater->toSupervisor($path, $process);
        fwrite($fd, $program->configFileContent());
        fclose($fd);
    }

    public function reloadSupervisorConfig()
    {
        try {
            $this->supervisordRpc->restart();
        } catch (\ErrorException $e) {
            Log::error($e->getMessage());
        }
    }
}