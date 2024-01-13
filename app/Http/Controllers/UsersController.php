<?php

namespace App\Http\Controllers;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Validators\UserValidators;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function create()
    {
        return view('admin.users.create');
    }


    public function store(Request $request)
    {
        $validator = UserValidators::validate('createUser', $request->all());

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return redirect()->route('users.create')->withErrors($errors)->withInput();
        }

        $data = [];
        $data ['name'] = $request->name;
        $data ['email'] = $request->email;
        $data ['password'] = Hash::make($request->password);

        $user = User::create($data);
        return redirect()->route('users.index');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
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
