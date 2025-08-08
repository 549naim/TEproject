@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa; /* হালকা ব্যাকগ্রাউন্ড */
    }
    .login-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .login-card {
        width: 100%;
        max-width: 400px;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #e0e0e0;
    }
    .login-card .card-header {
        background-color: #fff;
        border-bottom: none;
        text-align: center;
        font-weight: bold;
        font-size: 20px;
    }
    .login-card .form-control {
        border-radius: 6px;
        padding: 10px;
    }
    .btn-login {
        width: 100%;
        font-weight: 600;
    }
</style>

<div class="login-wrapper">
    <div class="card login-card">
        <div class="card-header">{{ __('Login') }}</div>

        <div class="card-body p-4">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-login">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                    <div class="mt-3 text-center">
                        <a class="text-decoration-none" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection




{{-- <!DOCTYPE html>
<html lang="en">


<head>
    <title>Login </title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="{{ asset('assets/images/iqac.png') }}" type="image/x-icon">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        id="main-font-link">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">


</head>

<body>
    <div class="auth-main">
        <div class="auth-wrapper v3">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-end mb-4">
                            <h3 class="mb-0"><b>Login</b></h3>
                           
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="Email Address">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-flex mt-1 justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input input-primary" type="checkbox" id="customCheckc1"
                                        checked="">
                                    <label class="form-check-label text-muted" for="customCheckc1">Keep me sign
                                        in</label>
                                </div>

                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                        <div class="d-grid mt-3 text-end">
                            @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

</body>

</html> --}}
