<?php
// app/Helpers/AuthHelper.php

use Illuminate\Support\Facades\Auth;
use App\Models\Permission;

function checkUserPermission($action)
{
    $user = Auth::user();

    // Get the permission associated with the action
    $permission = Permission::where('name', $action)->first();

    // Check if the user has the necessary permission
    return $user && $permission && $user->hasPermission($permission->name);
}
