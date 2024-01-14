<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleActionMapping extends Model
{
    use HasFactory;
    protected $fillable = ['role_id', 'action_id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function actions()
    {
        return $this->belongsTo(Action::class);
    }
}
