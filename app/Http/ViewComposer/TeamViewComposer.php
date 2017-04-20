<?php
namespace App\Http\ViewComposer;

use Illuminate\View\View;
use App\Model\Team;
use Illuminate\Http\Request;

class TeamViewComposer
{
    public function compose(View $view)
    {
        $user = \Auth::user();
        if ($user) {
            $teams = $user->team;
            $view->with('teams', $teams);
        } else
            $view->with('teams', []);
    }
}