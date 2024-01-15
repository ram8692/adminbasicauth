<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function actions()
    {
        return $this->belongsToMany(Action::class, 'role_action_mapping');
    }

    public function roleActionMappings()
    {
        return $this->hasMany(RoleActionMapping::class);
    }
}
