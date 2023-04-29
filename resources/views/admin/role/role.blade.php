@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">Role List</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <th>permission</th>
                        <th>action</th>
                    </tr>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>
                               @foreach ($role->getPermissionNames() as $permissio)
                                  <span class="badge badge-primary my-1"> {{ $permissio }}</span>
                               @endforeach
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="">Edit</a>
                                        <a class="dropdown-item" href="{{ route('delete.permission',$role->id) }}">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Add Permission</div>
            <div class="card-body">
                <form action="{{ route('permission.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Add New Permission</label>
                        <input type="text" name="permission_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Add Permission"> 
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Add Role</div>
            <div class="card-body">
                <form action="{{ route('role.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Add New Permission</label>
                        <input type="text" name="role_name" class="form-control">
                    </div>
                    <h4>select permission</h4>
                    <div class="form-group">
                        @foreach ( $permissions as $permission)
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" name="permission[]" class="form-check-input" value="{{ $permission->id }}">{{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                        
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Add Permission"> 
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">User List And Role</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>
                               @forelse ($user->getRoleNames() as $role)
                                   <span class="badge badge-success">{{ $role }}</span>
                               @empty
                                   <span class="badge badge-light">Not Assign</span>
                               @endforelse
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('remove.role',$user->id) }}">Remove</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        @can('asign_role')
        <div class="card">
            <div class="card-header">Assign Role</div>
            <div class="card-body">
                <form action="{{ route('assign.role') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <select name="user_id" id="" class="form-control">
                            <option value="">--select user--</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="role" id="" class="form-control">
                            <option value="">--select role--</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="assign role"> 
                    </div>
                </form>
            </div>
        </div>  
        @endcan
        
    </div>
</div>



@endsection