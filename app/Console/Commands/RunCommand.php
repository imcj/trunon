<?php

namespace App\Console\Commands;

use App\Model\Process;
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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $daemon = $this->option("daemon");

        $process = Process::where("command", "php artisan serve --host 0.0.0.0 --port 8000")->first();
        if (null == $process) {
            $process = Process::create([
                "identifier" =>
            ])
        }

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
