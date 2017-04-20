<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Core\Deploy;
use App\Model\Process;
use Supervisor\Api;

class DeployTest extends TestCase
{
    use DatabaseMigrations;

    private $process;

    public function setUp()
    {
        parent::setUp();
        $this->seed("ProcessSeeder");
        $config = config('trunon');
        $rpc = new Api(
            $config['xmlrpc_host'], 
            $config['xmlrpc_port'],
            $config['xmlrpc_username'],
            $config['xmlrpc_password']);
        $this->process = Process::all()->first();
        $this->deploy = new Deploy(
            config("trunon.workspace_dir"),
            $this->process,
            $rpc
        );
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRun()
    {
        $this->deploy->run();
        $this->assertTrue(file_exists($this->deploy->processExecutePath()));
    }

    public function testReloadSupervisorConfig()
    {
        $this->deploy->reloadSupervisorConfig();
    }

    public function testSupervisordConfigFileContent()
    {
        $config = $this->deploy->supervisordConfigFileContent($this->process);
    }
}
