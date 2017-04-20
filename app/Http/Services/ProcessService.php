<?php
namespace App\Http\Services;

use App\Core\SupervisordRPCFactory;
use App\Core\SupervisordStateTransfer;
use App\Model\Process;
use App\Model\ProcessRepository;
use Supervisor\ApiException;

class ProcessService
{
    public function __construct()
    {
        $supervisordRpcFactory = new SupervisordRPCFactory();
        $this->supervisordRpc = $supervisordRpcFactory->create();
        $this->repository = new ProcessRepository();
        $this->supervisordStateTransfer = new SupervisordStateTransfer();
    }

    /**
     *
     * @return Process[] 进程列表
     */
    public function fetchProcessList($user, $teamId)
    {
        $processes = $this->repository->find($user, $teamId);
        
        foreach ($processes as $process) {
            
            try {
                $processInfo = $this->supervisordRpc->getProcessInfo(
                    $process->identifier);
                $state = $this->supervisordStateTransfer->toProcessEnum(    
                    $processInfo['state']);
            } catch (ApiException $exception) {
                $state = Process::UNKNOW;
            }
            $process->status = $state;
        }

        return $processes;
    }
}