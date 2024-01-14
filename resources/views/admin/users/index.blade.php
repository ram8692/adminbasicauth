@extends('admin.layouts.main')
@section('content')
 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Tables</h1>
<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="row">
                @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <form action="{{ route('users.index') }}" method="get">

                    <label for="name">Name:</label>
                    <input type="text" name="name" value="{{ request('name') }}">
                
                    <label for="email">Email:</label>
                    <input type="text" name="email" value="{{ request('email') }}">

                    <label for="from_date">From Date:</label>
                    <input type="date" name="from_date" value="{{ request('from_date') }}">
                
                    <label for="to_date">To Date:</label>
                    <input type="date" name="to_date" value="{{ request('to_date') }}">
                
                    <button type="submit">Filter</button>
                </form>
                
            </div>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><a href="{{ route('users.edit', ['id' => $user->id]) }}">Edit</a><a href="{{ route('users.destroy', ['id' => $user->id]) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $user->id }}').submit();">Delete</a><form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', ['id' => $user->id]) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form></td>
                        
                        <!-- Add more data columns as needed -->
                    </tr>

                @endforeach
                 
                </tbody>
            </table>
            {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}

        </div>
    </div>
</div>

</div>

<!-- /.container-fluid -->
@endsection