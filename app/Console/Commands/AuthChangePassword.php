<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class AuthChangePassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
        $user = User::where("email", $this->option("email"))->first();
        $user->changePassword($this->option("password"));
        $user->save();
    }
}
