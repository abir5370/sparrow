@extends('frontend.master')

@section('content')

<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">
        
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 m-auto">
                <div class="mb-3">
                    <h3>Change Password {{ $token }}</h3>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form class="border p-3 rounded" action="{{ route('password.reset.confirm') }}" method="POST">
                    @csrf				
                    <div class="form-group">
                        <label>New Password *</label>
                        <input type="hidden" class="form-control" name="token" value="{{ $token }}">
                        <input type="password" class="form-control" name="password" placeholder="New Password*">
                    </div> 
                    <div class="form-group">
                        <label>Confirm Password *</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password*">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Reset Password</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection