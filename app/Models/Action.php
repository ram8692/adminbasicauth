<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_action_mapping');
    }

    public function rolePermissionMappings()
    {
        return $this->hasMany(RoleActionMapping::class);
    }
}
