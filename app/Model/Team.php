<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Process;
use App\User;
use Bican\Roles\Models\Role;

class Team extends Model
{
    protected $fillable = ['name'];

    public function process()
    {
        return $this->hasMany(Process::class);
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, "teams_users");
    }
}
