@extends('layouts.app')

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden; 
        background-color: #ffffff;
    }
    .login-wrapper {
        height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    .logo-section {
        text-align: center;
        margin-bottom: 20px;
    }
    .logo-section img {
        max-width: 120px;
        height: auto;
    }
    .logo-title {
        margin-top: 10px;
        font-size: 22px;
        font-weight: bold;
        color: #800000;
    }
    .logo-subtitle {
        font-size: 18px;
        font-weight: 600;
        color: #b30000;
    }
    .login-card {
        width: 100%;
        max-width: 400px;
        border-radius: 10px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        background: #fff;
        padding: 25px;
    }
    .form-label {
        font-weight: 500;
    }
    .form-control {
        border-radius: 6px;
        padding: 10px;
    }
    .btn-login {
        width: 100%;
        font-weight: 600;
        border-radius: 6px;
        padding: 10px;
    }
    .forgot-link {
        margin-top: 12px;
        display: block;
        text-align: center;
        font-size: 14px;
    }
</style>

<div class="login-wrapper">
    <!-- Logo Section -->
    <div class="logo-section">
        <img src="{{ asset('assets/images/iqac.png') }}" alt="MBSTU Logo">
        <div class="logo-title">Teaching Evaluation Portal, MBSTU</div>
    </div>

    <!-- Login Card -->
    <div class="login-card">
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
                <a class="forgot-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </form>
    </div>
</div>
@endsection
