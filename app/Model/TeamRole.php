<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Bican\Roles\Models\Role;
use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;

class TeamRole extends Pivot implements HasRoleAndPermissionContract
{
    use HasRoleAndPermission;
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
} 