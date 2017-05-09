<?php

use Illuminate\Database\Seeder;
use App\Model\Team;
use App\User;
use App\Model\Process;

class InitializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team = Team::create(array("name" => "公共团队"));
        $password = rand();

        echo "Initialized password is $password\n";

        $user = User::create([
            "name" => "admin",
            "email" => 'admin@trunon.com',
            'password' => bcrypt($password),
            'team_id' => $team->id
        ]);

        $process = Process::create(array(
            "identifier" => "demo",
            "team_id" => $team->id,
            "owner_id" => $user->id,
            "deploy" => Process::DEPLOY_CODE,
            "code" => "#!/usr/bin/env bash\n" . 
                "while true\n" .
                "do\n" .
                "curl http://counter.duapp.com/?sleep=4\n" .
                "sleep 5\n" .
                "done\n" .
                "exit 0"
        ));
    }
}
