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
        return $this->hasOne(Process::class);
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, "teams_users");
    }

    public function users()
    {
        return $this->belongsToMany(User::class, "teams_users");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "teams_users");
    }
}
