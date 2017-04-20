<?php
namespace App\Model;

class ProcessRepository
{

    public function find($user, $teamId)
    {
        $processes = Process::with('team');
        if ($teamId > 0)
            $processes = $processes->where("team_id", $teamId)->get();
        else
            $processes = $processes->where("team_id", $user->team->first()->id)->get();
        
        return $processes;
    }

    public function all()
    {
        return Process::with("team.user")->all();
    }
}