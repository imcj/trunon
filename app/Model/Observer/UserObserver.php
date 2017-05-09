<?php
namespace App\Model\Observer;

use App\User;
use App\Model\Profile;
use App\Model\AppNotification;
use App\Model\Team;
use Bican\Roles\Models\Role;

class UserObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->save();

        $developerRole = Role::where("slug", "developer")->first();
        $userRole = Role::where("slug", "user")->first();
        $team = Team::create(['name' => '初始团队']);
        $team->users()->attach($user);
        
        $ownTeamPivot = $user->team->first()->pivot;
        $ownTeamPivot->role_id = $developerRole->id;
        $ownTeamPivot->save();

        $globalTeam = Team::where("name", "公共团队")->first();
        $globalTeam->users()->attach($user);

        $globalTeamPivot = $user
            ->team()
            ->wherePivot('team_id', '=', $globalTeam->id)
            ->first()
            ->pivot;

        $globalTeamPivot->role_id = $userRole->id;
        $globalTeamPivot->save();

        AppNotification::create([
            'user_id' => $user->id,
            'type' => 'default',
            'subject' => '欢迎',
            'content' => '有任何问题可以在线咨询。'
        ]);
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        //
    }
}
