@extends('admin.layouts.main')
@section('content')
 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Tables</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('users.store') }}" class="user">
            @csrf
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="exampleFirstName"
                        placeholder="First Name" name="first_name">
                </div>
                <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="exampleLastName"
                        placeholder="Last Name" name="last_name">
                </div>
            </div>
            <div class="form-group">
                <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                    placeholder="Email Address" name="email">
            </div>
            <div class="form-group">
                <select name="role_id" class="form-control" id="">
                    <option value="" selected >select role</option>
                    <option value="1" selected >Admin</option>
                    <option value="2" selected >User</option>
                </select>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user"
                        id="exampleInputPassword" placeholder="Password" name="password">
                </div>
                <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user"
                        id="exampleRepeatPassword" placeholder="Repeat Password" name="c_password">
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-user btn-block">Create User</button>
            <hr>
        </form>
    </div>
</div>

</div>
<!-- /.container-fluid -->
@endsection