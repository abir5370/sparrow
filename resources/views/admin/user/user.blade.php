@extends('layouts.dashboard')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @endif
            @can('user')
            <div class="card">
                <div class="card-header bg-primary text-white">View User List</div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>si</th>
                                <th>name</th>
                                <th>email</th>
                                <th>photo</th>
                                <th>created_at</th>
                                @can('User_delete')
                                    <th>action</th>
                                @endcan
                            </tr>
                            @foreach($users as $key=>$user)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->photo == null)
                                        <img width="50" src="{{ Avatar::create($user->name)->toBase64() }}" />
                                        @else
                                            <img width="50" src="{{ 'uploads/user/'.$user->photo}}" alt="">
                                        @endif
                                    </td>
                                    <td> {{$user->created_at->diffForHumans()}} </td>
                                    @can('User_delete')
                                        <td>
                                            <a href="{{route('user.delete',$user->id)}}" class="btn btn-danger">delete</a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </table> 
                    </div>
            </div>
            @endcan
        </div>
    </div>
</div>
@endsection