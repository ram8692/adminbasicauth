<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    public function index()
    {
        $actions = Action::all();
        $roles = Role::all();

        return view('admin.permissions.index', compact('actions', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'actions' => 'required|array',
        ]);
    
        DB::transaction(function () use ($request) {
            foreach ($request->actions as $role_id => $action_ids) {
                $role = Role::findOrFail($role_id);
                $role->actions()->sync($action_ids);
            }
        });
    
        return redirect()->route('permission.index')->with('success', 'Permissions granted successfully.');
    }

    public function grantPermission(Request $request)
    {
        $request->validate([
            'action_id' => 'required|exists:actions,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $action = Action::find($request->action_id);
        $role = Role::find($request->role_id);

        if ($action && $role) {
            $role->grantPermission($action);
            return redirect()->route('permissions.index')->with('success', 'Permission granted successfully.');
        }

        return redirect()->route('permissions.index')->with('error', 'Failed to grant permission.');
    }

}
