<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Role;
use App\Validators\UserValidators;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Apply filters as needed
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', $request->input('email'));
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            // Both 'from_date' and 'to_date' are provided
            $query->whereBetween('created_at', [$request->input('from_date'), $request->input('to_date')]);
        } elseif ($request->filled('from_date')) {
            // Only 'from_date' is provided
            $query->where('created_at', '>=', $request->input('from_date'));
        } elseif ($request->filled('to_date')) {
            // Only 'to_date' is provided
            $query->where('created_at', '<=', $request->input('to_date'));
        }

        $users = $query->paginate(10); // You can adjust the number of items per page

        return view('admin.users.index', compact('users'));
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create',compact('roles'));
    }


    public function store(Request $request)
    {
        $validator = UserValidators::validate('createUser', $request->all());

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return redirect()->route('users.create')->withErrors($errors)->withInput();
        }

        $data = [];
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['role_id'] = $request->role_id;
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        return redirect()->route('users.index');
    }


    public function edit($id)
    { //dd($id);
        $user = User::findOrFail($id);
        //print_r($user->name);
        return view('admin.users.update', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validator = UserValidators::validate('updateUser', $request->all());

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return redirect()->route('users.edit', ['id' => $id])->withErrors($errors)->withInput();
        }

        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email' /* other fields */]));

        return redirect()->route('users.index');
    }



    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index');
    }

}
