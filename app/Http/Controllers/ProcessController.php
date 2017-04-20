<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Deploy;
use App\Core\SupervisordRPCFactory;
use App\Model\Process;
use App\Model\Team;
use App\Http\Services\ProcessService;
use Supervisor\Api;

/**
 *
 * - [ ] 增加编辑进程
 */
class ProcessController extends Controller
{
    /**
     * @var Deploy
     */
    private $deploy;

    private $supervisordRpc;

    /**
     *
     * 处理进程的服务
     *
     * @var ProcessService
     */
    private $processService;

    public function __construct()
    {
        // parent::__construct();

        $config = config('trunon');
        $this->workspaceDir = $config['workspace_dir'];
        
        $supervisordRPCFactory = new SupervisordRPCFactory();
        $this->supervisordRpc = $supervisordRPCFactory->create();
        $this->processService = new ProcessService();
    }

    function createDeploy($process)
    {
        return new Deploy($this->workspace, $process, $this->supervisorRpc);
    }


    /**
     *
     * TODO: 启动和重新启动进程
     * TODO: 
     */
    public function index($teamId = 0)
    {
        $user = \Auth::user();
        $teamBuilder = $user->team;
        if (0 == $teamId)
            $team = $teamBuilder->first();
        else
            $team = $teamBuilder->where('id', $teamId)->first();
        $permissions = $team->pivot->role->permissions->all();

        return view("process/index", [
            "permissions" => $permissions,
            // "userCanCreateProcess" => $userCanCreateProcess,
            "processes" => $this->processService->fetchProcessList($user, $teamId)
        ]);
    }

    public function create()
    {
        return view("process/create", [
        ]);
    }

    /**
     *
     * TODO: 持久化进程信息后部署到Supervisord
     * TODO: Validate form
     */
    public function store(Request $request)
    {
        $owner = \Auth::user();
        $team = $owner->team;
        $data = $request->all();
        $data['owner_id'] = $owner->id;
        $data['team_id'] = $team->id;
        $process = Process::create($data);
        $deploy = new Deploy(
            $this->workspaceDir,
            $process,
            $this->supervisordRpc
        );
        $deploy->run();

        return redirect()->route("process.index", []);
    }

    /**
     *
     * TODO: Finish this action
     */
    public function edit($processId)
    {
        $process = Process::find($processId);
        return view('process/edit', [
            'process' => $process
        ]);
    }

    /**
     *
     * TODO: Finish this action
     */
    public function update($processId, Request $request)
    {
        $process = Process::find($processId);
        $process->update($request->all());

        $deploy = new Deploy(
            $this->workspaceDir,
            $process,
            $this->supervisordRpc
        );
        $deploy->run();
        return redirect()->route("process.edit", [$process->id]);
    }

    public function destroy($processId)
    {
        $process = Process::find($processId);
        $deploy = new Deploy(
            $this->workspaceDir,
            $process,
            $this->supervisordRpc
        );
        $deploy->remove();
        $process->delete();
        return response()->json([
            "message" => "ok"
        ]);
    }

    public function stop($id)
    {
        $process = Process::find($id);
        $response = $this->supervisordRpc->stopProcess(
            $process->identifier, 
            false
        );
    }

    public function start($id)
    {
        $process = Process::find($id);
        $response = $this->supervisordRpc->startProcess(
            $process->identifier, 
            false
        );
    }

    public function restart($id)
    {
        $process = Process::find($id);
        $response = $this->supervisordRpc->stopProcess(
            $process->identifier, 
            true
        );

        Log::info(var_export($response, true));

        $response = $this->supervisordRpc->startProcess(
            $process->identifier, 
            true
        );

        Log::info(var_export($response, true));
    }

    public function reload($id)
    {
        $process = Process::find($id);
    }
}