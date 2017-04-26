<?php
namespace App\Core;

use App\Model\Process;
use \Supervisor\Api;
use \Supervisor\ApiException;
use Log;

class Deploy
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
        Process $process,
        Api $supervisordRpc)
    {
        $this->workspaceDir = $workspaceDir;
        $this->process = $process;
        $this->supervisordRpc = $supervisordRpc;
    }

    public function processDir()
    {
        return "{$this->workspaceDir}/process/" .
            "{$this->process->identifier}";
    }

    public function processExecutePath()
    {
        if ($this->process->deploy == strtolower(Process::DEPLOY_CODE)) {
            return $this->processDir() . "/{$this->process->identifier}";
        }
    }

    public function supervisordConfigFilePath()
    {
        return "{$this->workspaceDir}/conf.d" . 
            "/{$this->process->identifier}.conf";
    }

    public function remove()
    {
        try {
            $this->supervisordRpc->stopProcess($this->process->identifier);
        } catch(ApiException $exception) {
            Log::info($exception->getMessage());
        }
        Log::info("Delete " . $this->supervisordConfigFilePath());
        Log::info("Delete " . $this->processDir());
        @unlink($this->supervisordConfigFilePath());
        // TODO: 用PHP方法实现
        system("rm -rf " . $this->processDir());
        // rmdir($this->processDir());
    }

    /**
     * 部署进程执行代码到 workspace 目录中。
     * [x] 部署执行代码到 workspace 目录
     * [x] 生成和部署 supervisord 配置文件
     * [x] 在部署任务完成后启动进程
     *
     * @return void
     */
    public function run()
    {
        $this->deployProcess();
        $this->deploySupervisordProcessConfigFile();
        $this->reloadSupervisorConfig();
    }

    function deployProcess()
    {
        Log::info("部署进程 类型:{$this->process->deploy}");
        if ($this->process->deploy == strtolower(Process::DEPLOY_CODE)) {
            Log::info("部署源代码到 {$this->processExecutePath()}");
            if (!file_exists($this->processDir()))
                mkdir($this->processDir(), 0755, true);
            $fd = fopen($this->processExecutePath(), "w");
            $code = str_replace("\r\n", "\n", $this->process->code);
            fwrite($fd, $code);
            fclose($fd);
            chmod($this->processExecutePath(), 0755);
        }

        @mkdir($this->processDir() . "/log", 0755, true);
    }

    function deploySupervisordProcessConfigFile()
    {
        $fd = fopen($this->supervisordConfigFilePath(), "w");
        fwrite($fd, $this->supervisordConfigFileContent($this->process));
        fclose($fd);
    }

    public function reloadSupervisorConfig()
    {
        $this->supervisordRpc->restart();
    }

    public function supervisordConfigFileContent($process)
    {
        return $process->toSupervisordConfigFile(
            $this->processExecutePath(),
            $this->processDir()
        );
    }
}