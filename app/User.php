<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Model\Profile;
use App\Model\Team;
use App\Model\Events\UserSaved;

use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;

class User extends Authenticatable implements HasRoleAndPermissionContract
{
    use Notifiable;
    use HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $events = [
        'saved' => UserSaved::class
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class, "user_id");
    }

    public function team()
    {
        return $this->belongsToMany(Team::class, "teams_users")->withPivot('role_id', 'id')
        ->using('App\Model\TeamRole');
    }

    public static function default()
    {
        $user = User::first();
        assert(null != $user);
        return $user;
    }
}
