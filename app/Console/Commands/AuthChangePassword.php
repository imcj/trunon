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
    protected $signature = 'auth:password {email} {password}';

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
        $user = User::where("email", $this->argument("email"))->first();
        $user->changePassword($this->argument("password"));
        $user->save();
    }
}
