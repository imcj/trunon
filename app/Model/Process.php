<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Model\Team;

use App\Core\SupervisordRPCFactory;
use App\Core\SupervisordStateTransfer;
use Supervisor\ApiException;

class Process extends Model
{
    const STARTING = "STARTING";
    const STOPPED = 'STOPPED';
    const STOPPING = 'STOPPING';
    const BACKOFF = 'BACKOFF';
    const RUNNING = 'RUNNING';
    const FATAL = 'FATAL';
    const EXITED = 'EXITED';
    const UNKNOW = 'UNKNOW';

    const DEPLOY_CODE = "CODE";
    const DEPLOY_ZIP = "ZIP";

    protected $fillable = [
        'identifier', 'name', 'status', 'deploy', 'process_number', 'code',
        'team_id', 'owner_id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supervisorStatus()
    {
        $supervisordRpcFactory = new SupervisordRPCFactory();
        $supervisordRpc = $supervisordRpcFactory->create();
        $supervisordStateTransfer = new SupervisordStateTransfer();

        try {

            $processInfo = $supervisordRpc->getProcessInfo(
                $this->identifier);
            $state = $supervisordStateTransfer->toProcessEnum(    
                $processInfo['state']);
        } catch (ApiException $exception) {
            $state = Process::UNKNOW;
        }

        return $state;
    }

    public function canStart()
    {
        return in_array($this->status, [
            Process::STOPPED, Process::BACKOFF, Process::FATAL, Process::EXITED,
            Process::UNKNOW
        ]);
    }

    public function canStopOrRestart()
    {
        return in_array($this->status, [
            Process::STARTING, Process::RUNNING
        ]);
    }

    public function toSupervisordConfigFile($processExecutePath, $processDir)
    {
        $config = [];
        $config[] = "[program:{$this->identifier}]";
        $config[] = "command = $processExecutePath";
        $config[] = "numproc = {$this->process_number}";
        $config[] = "stdout_logfile = {$processDir}/log/stdout.log";
        $config[] = "stderr_logfile = {$processDir}/log/stderr.log";
        $config[] = "directory = {$processDir}";

        return join("\n", $config);
    }
}
