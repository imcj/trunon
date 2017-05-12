<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Process;
use App\User;
use Bican\Roles\Models\Role;

class Team extends Model
{
    protected $fillable = ['name'];

    public static $defaultName = "公共团队";

    public function process()
    {
        return $this->hasMany(Process::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, "teams_users");
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, "teams_users");
    }

    public static function default()
    {
        return Team::where("name", self::$defaultName);
    }
}
