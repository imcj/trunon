<?php
namespace App\Core\Supervisor;

class Program
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $command;

    /**
     * @var integer
     */
    private $processNumber;

    /**
     * @var string
     */
    private $stdoutFile;

    /**
     * @var string
     */
    private $stderrFile;

    /**
     * @var string
     */
    private $directory;

    /**
     * @var string
     */
    private $environment;

    public function __construct(
        $identifier,
        $command,
        $processNumber,
        $stdoutFile,
        $stderrFile,
        $directory,
        $environment)
    {
        $this->identifier = $identifier;
        $this->command = $command;
        $this->processNumber = $processNumber;
        $this->stdoutFile = $stdoutFile;
        $this->stderrFile = $stderrFile;
        $this->directory = $directory;
        $this->environment = $environment;
    }

    /**
     * @return string
     */
    public function identifier()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function command()
    {
        return $this->command;
    }

    /**
     * @return int
     */
    public function processNumber()
    {
        return $this->processNumber;
    }

    /**
     * @return string
     */
    public function stdoutFile()
    {
        return $this->stdoutFile;
    }

    /**
     * @return string
     */
    public function stderrFile()
    {
        return $this->stderrFile;
    }

    /**
     * @return string
     */
    public function directory()
    {
        return $this->directory;
    }

    public function environment()
    {
        return $this->environment;
    }

    public function configFileContent()
    {
        $config = [];
        $config[] = "[program:{$this->identifier}]";
        $config[] = "command = $this->command";
        $config[] = "numproc = {$this->processNumber}";
        $config[] = "stdout_logfile = {$this->stdoutFile}";
        $config[] = "stderr_logfile = {$this->stderrFile}";
        $config[] = "directory = {$this->directory}";
        $config[] = "environment = {$this->environment}";

        return join("\n", $config);
    }
}