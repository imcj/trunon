<?php

namespace App\Console\Commands;

use App\Core\Deploy;
use App\Model\Process;
use App\Model\Team;
use App\User;
use Illuminate\Console\Command;

class RunCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run {--D|daemon}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var Deploy
     */
    private $deploy;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Deploy $deploy)
    {
        parent::__construct();
        $this->deploy = $deploy;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $daemon = $this->option("daemon");

        $command = "php artisan serve --host 0.0.0.0 --port 8000";
        $process = Process::where("command", $command)->first();
        $defaultTeam = Team::default();
        $defaultUser = User::default();

        $processData = [
            "identifier" => "trunon_server",
            "command" => $command,
            "deploy" => Process::DEPLOY_COMMAND,
            "process_number" => 1,
            "team_id" => $defaultTeam->id,
            "user_id" => $defaultUser->id,
            "root_directory" => base_path()
        ];

        if (null == $process) {
            $process = Process::create($processData);
        } else {
            $process->update($processData);
        }
        $this->deploy->do($process);

        while (true) {
            $cmd =  "php artisan supervisord:run";
            if ($daemon) {
                $cmd .= " --daemon";
            }
            $cmd .= " 2>&1";
            if ($daemon) {
                system($cmd);
                exit(0);
            }

            $fd = popen($cmd, "r");

            while (true) {
                $gets = fread($fd, 512 *100);
                echo $gets;
                if (!$gets || $gets == "") {
                    break;
                }
            }
            sleep(1);
        }
    }
}
