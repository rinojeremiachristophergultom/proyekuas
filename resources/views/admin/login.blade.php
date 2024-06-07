@extends('layout.auth')

@section('title', 'Login')

@section('content')
    
    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                <form class="user" method="POST" action="{{ route('admin.login') }}">
                                    @csrf

                                    @if (session('message_fail'))
                                        <div class="alert alert-danger alert-dismissible show fade">
                                            <div class="alert-body">
                                                <button class="close" data-dismiss="alert">
                                                    <span></span>
                                                </button>
                                                {{ session('message_fail') }}
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if (session('message_success'))
                                        <div class="alert alert-success alert-dismissible show fade">
                                            <div class="alert-body">
                                                <button class="close" data-dismiss="alert">
                                                    <span></span>
                                                </button>
                                                {{ session('message_success') }}
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <label for="inputusername" class="text-gray-900">Username</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="inputusername" 
                                        aria-describedby="emailHelp" name="username">
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="InputPassword" class="text-gray-900">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="InputPassword" 
                                        name="password">
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" name="remember" id="customCheck" {{ old('remember') ? 
                                            'checked' : '' }}>
                                            <label class="custom-control-label" for="customCheck">Remember Me</label>
                                        </div>
                                    </div>
                                    <button type="submit" name="login" class="btn btn-primary btn-user btn-block">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection