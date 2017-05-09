<?php

use Illuminate\Database\Seeder;
use App\Model\Team;
use App\User;
use App\Model\Process;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->truncate();
        DB::table('users')->truncate();
        DB::table('processes')->truncate();

        $team = Team::create(array("name" => "公共团队"));

        $user = User::create([
            "name" => "trunon",
            "email" => 'trunon@example.com',
            'password' => bcrypt('trunon'),
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
