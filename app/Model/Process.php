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
    const DEPLOY_COMMAND = "COMMAND";

    protected $fillable = [
        'identifier', 'name', 'status', 'deploy', 'process_number', 'code',
        'command', 'team_id', 'owner_id', 'root_directory'];

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
        if (!$this->status) {
            $this->status = $this->supervisorStatus();
        }
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



    }
}
