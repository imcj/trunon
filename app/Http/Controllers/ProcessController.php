<?php

namespace App\Http\Controllers;

use App\Core\Supervisor\Path;
use App\Http\Requests\ProcessRequest;
use Log;
use Illuminate\Http\Request;
use App\Core\Deploy;
use App\Core\SupervisordRPCFactory;
use App\Model\Process;
use App\Model\Team;
use App\Http\Services\ProcessService;
use Supervisor\Api;

/**
 *
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

    public function __construct(Deploy $deploy)
    {
        // parent::__construct();
        $this->deploy = $deploy;
        $this->processService = new ProcessService();
        $factory = new SupervisordRPCFactory();
        $this->supervisordRpc = $factory->create();
    }

    public function index()
    {
        return $this->overview();
    }

    /**
     *
     */
    public function team($teamId = 0)
    {
        $user = \Auth::user();
        $teamBuilder = $user->team;
        if (0 == $teamId)
            $team = $teamBuilder->first();
        else
            $team = $teamBuilder->where('id', $teamId)->first();
        $permissions = $team->pivot->role->permissions->all();

        Log::debug("User {$user->id} ", ['user' => $user]);
        Log::debug("Team {$team->id}", ['team' => $team]);
        Log::debug("Permissions ", ['permissions' => $permissions]);

        return view("process/index", [
            "permissions" => $permissions,
            "processes" => $this->processService->fetchProcessList($user, $teamId)
        ]);
    }

    public function overview()
    {
        $userId = \Auth::id();
        $user = $this->processService->fetchTeamProcessListByUserId($userId);

        return view("process/overview", [
            "teams" => $user->team
        ]);
    }

    public function create($teamId)
    {
        $process = new Process();
        $process->process_number = 1;
        $process->deploy = Process::DEPLOY_COMMAND;
        return view("process/create", [
            'teamId' => $teamId,
            'process' => $process
        ]);
    }

    /**
     *
     */
    public function store($teamId, ProcessRequest $request)
    {
        $owner = \Auth::user();
        $team = Team::find($teamId);
        $data = $request->all();

        $process = new Process();
        $process->identifier = $request->get("identifier");
        $process->deploy = $request->get("deploy", "command");
        $process->command = $request->get("command");
        $process->code = $request->get("code");
        $process->process_number = $request->get("process_number");
        $process->root_directory = $request->get("root_directory");
        $process->owner_id = $owner->id;
        $process->team_id = $team->id;

//        $data['owner_id'] = $owner->id;
//        $data['team_id'] = $team->id;
//        $process = Process::create($data);
        $config = config('trunon');
        $workspaceDir = $config['workspace_dir'];
        $path = new Path($workspaceDir, $process);

        $process->root_directory = $path->processDir();
        $process->save();

        $this->deploy->do($process);

        return redirect()->route("process.index", []);
    }

    /**
     *
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
     */
    public function update($processId, ProcessRequest $request)
    {
        $process = Process::find($processId);
        $process->update($request->all());

        $this->deploy->do($process);
        return redirect()->route("process.edit", [$process->id]);
    }

    public function destroy($processId)
    {
        $process = Process::find($processId);
        $this->deploy->remove($process);
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