@extends('layouts.dashboard')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                @if(session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                <div class="card-header bg-primary text-white">Edit Profile</div>
            
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ auth::user()->name }}">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ auth::user()->email }}">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                @if(session('password'))
                    <div class="alert alert-success">{{session('password')}}</div>
                @endif
                  
                @if(session('failed'))
                    <div class="alert alert-danger">{{session('failed')}}</div>
                @endif
                <div class="card-header bg-primary text-white">Change Password</div>
            
                <div class="card-body">
                    <form action="{{ route('update.password') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Old Password</label>
                            <input type="password" name="old_password" class="form-control">                      
                            @error('old_password')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">New Password</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')
                             <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                            @error('password_confirmation')
                             <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                @if(session('image'))
                    <div class="alert alert-success">{{session('image')}}</div>
                @endif
                <div class="card-header bg-primary text-white">edit profile photo</div>
            
                <div class="card-body">
                    <form action="{{ route('update.photo') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Photo</label>
                            <input type="file" name="photo" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"><br>
                            <img width="70" id="blah" src="" alt="">                      
                            @error('old_password')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection