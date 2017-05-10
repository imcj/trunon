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
        
        $processId = posix_getpid();
        file_put_contents("/tmp/trunon.log", "father " . $processId . "\n", FILE_APPEND);

        // TODO: Reap
        $pid = pcntl_fork();
        if ($pid == 0) {
            $processId = posix_getpid();
            $processIdFile = "/tmp/trunon.pid";

            if (file_exists($processIdFile)) {
                $runningProcessId = (int)file_get_contents($processIdFile);
                if (posix_kill($runningProcessId, 0))
                    exit(0);
            }

            file_put_contents("/tmp/trunon.log", "son child " . $processId . "\n", FILE_APPEND);

            $ppid = pcntl_fork();
            if ($ppid > 0)
                exit(0);
            
            fclose(STDIN);
            fclose(STDOUT);
            fclose(STDERR);

            posix_setsid();

            $processId = posix_getpid();
            file_put_contents($processIdFile, $processId);
            file_put_contents("/tmp/trunon.log", "grand child pid " . $processId . "\n", FILE_APPEND);

            while (true) {
                $cmd = "php artisan serve 2>&1";

                if ($daemon) {
                    system($cmd);
                    return;
                }
                $fd = popen($cmd, "r");
                
                if (!$daemon) {
                    while (true) {
                        $gets = fread($fd, 512 * 100);
                        echo $gets;
                        if (!$gets || $gets == "") {
                            break;
                        }
                    }
                }
                sleep(10);
            }
        } else if ($pid > 0) {
            while (true) {
                $cmd =  "php artisan supervisord:run";
                if ($daemon) {
                    $cmd .= " --daemon";
                }
                $cmd .= " 2>&1";
                if ($daemon) {
                    system($cmd);
                    exit(0);
                    echo "Command exit";
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
        } else {
            echo "Fork failure.";
        }
    }
}
