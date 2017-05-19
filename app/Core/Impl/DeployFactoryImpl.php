<?php
namespace App\Core\Impl;


use App\Core\Deploy;
use App\Core\DeployFactory;
use App\Core\SupervisordRPCFactory;
use Supervisor\Api;

class DeployFactoryImpl implements DeployFactory
{
    /**
     * Supervisor目录
     *
     * @var string
     */
    private $workspaceDir;

    /**
     * @var Api
     */
    private $api;

    /**
     * DeployFactoryImpl constructor.
     */
    public function __construct()
    {
        $config = config('trunon');
        $this->workspaceDir = $config['workspace_dir'];

        $supervisordRPCFactory = new SupervisordRPCFactory();
        $this->api = $supervisordRPCFactory->create();
    }

    /**
     * Deploy类的工厂类
     *
     * @return Deploy
     */
    function create()
    {
        return new DeployImpl($this->workspaceDir, $this->api);
    }
}