<?php
namespace App\Core;

use App\Model\Process;

interface Deploy
{
    /**
     * 执行部署
     *
     * Deploy由DeployFactory->create构造
     *
     * @see \App\Core\DeployFactory;
     * @param Process $process
     * @return void
     */
    function do(Process $process);
}