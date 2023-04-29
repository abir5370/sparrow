@extends('frontend.master')

@section('content')

<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Login</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Login Detail ======================== -->
<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">
        
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="mb-3">
                    <h3>Login</h3>
                </div>
                @if(session('verifyemail'))
                <div class="alert alert-success">{{ session('verifyemail') }}</div>
                @endif
                @if(session('Login'))
                    <div class="alert alert-warning">{{ session('Login') }}</div>
                @endif
                <form class="border p-3 rounded" action="{{ route('customer.login') }}" method="POST">	
                    @csrf			
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="text" name="email" class="form-control" placeholder="Email*">
                    </div>
                    
                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password" name="password" class="form-control" placeholder="Password*">
                    </div>
                    
                    <div class="form-group">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="eltio_k2">
                                <a href="{{ route('password.reset.req.form') }}">Lost Your Password?</a>
                            </div>	
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login</button>
                    </div>
                    <div class="my-4 text-center">
                        <a href="{{ route('github.redirect') }}" class="btn btn-light" width="20">login with <img src="https://i.postimg.cc/wBBfFRkz/001-github-sign.png" alt=""></a>
                        <a href="{{ route('google.redirect') }}" class="btn btn-light" width="20">login with <img src="https://i.postimg.cc/FKnP6FPL/003-search.png" alt=""></a>
                        <a href="" class="btn btn-light" width="20">login with <img src="https://i.postimg.cc/rm0h26bY/002-facebook.png" alt=""></a>
                    </div>
                </form>
            </div>
            
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mfliud">
                <div class="mb-3">
                    <h3>Register</h3>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('verify'))
                <div class="alert alert-success">{{ session('verify') }}</div>
                @endif
                <form class="border p-3 rounded" action="{{ route('customer.regi') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Full Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="Full Name">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="text" name="email" class="form-control" placeholder="Email*">
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Password *</label>
                            <input type="password" name="password" class="form-control" placeholder="Password*">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Create An Account</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</section>



@endsection