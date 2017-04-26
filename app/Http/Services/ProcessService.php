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
        $this->configProcess($processes);
        return $processes;
    }

    public function fetchTeamProcessListByUserId($userId)
    {
        $user = \App\User::with(['team', 'team.process' => function($query) {
            $query->limit(15);
        }, 'team.role'])->where('id', $userId)->first();

        foreach ($user->team as $team)
            assert($team->pivot->role != null);

        return $user;
    }

    function configProcess($processes)
    {
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