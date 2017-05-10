<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SupervisordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supervisord:run {--D|daemon}';

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
        $config = config("trunon");
        $workspaceDir = config("trunon.workspace_dir");
        $template = file_get_contents(base_path("supervisord/supervisord.conf"));
        $supervisordConfig = str_replace(
            "%WORKSPACE_DIR%",
            $workspaceDir,
            $template
        );

        $supervisordConfig = str_replace(
            "%SUPERVISORD_XMLRPC_HOST%",
            $config['xmlrpc_host'],
            $supervisordConfig
        );

        $supervisordConfig = str_replace(
            "%SUPERVISORD_XMLRPC_PORT%",
            $config['xmlrpc_port'],
            $supervisordConfig
        );

        $supervisordConfig = str_replace(
            "%SUPERVISORD_XMLRPC_USERNAME%",
            $config['xmlrpc_username'],
            $supervisordConfig
        );

        $supervisordConfig = str_replace(
            "%SUPERVISORD_XMLRPC_PASSWORD%",
            $config['xmlrpc_password'],
            $supervisordConfig
        );

        $fp = fopen($workspaceDir . "/supervisord.conf", "w");
        fwrite($fp, $supervisordConfig);
        fclose($fp);

        @mkdir($workspaceDir . "/log", 0755, true);
        @mkdir($workspaceDir . "/conf.d", 0755, true);

        $daemon = $this->option("daemon");
        $cmd = "supervisord";
        if (!$daemon) {
            $cmd .= " -n";
        }
        $cmd .= " -c $workspaceDir/supervisord.conf";
        system($cmd);
    }
}
