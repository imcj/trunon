<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run';

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
        // TODO: Reap
        $pid = pcntl_fork();
        if ($pid) {

            while (true) {
                $fd = popen("php artisan serve 2>&1", "r");
            
                while (true) {
                    $gets = fread($fd, 512 *100);
                    echo $gets;
                    if (!$gets || $gets == "") {
                        break;
                    }
                }
                sleep(1);
            }
        } else {
            while (true) {
                $fd = popen("php artisan supervisord:run 2>&1", "r");
            
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
}
