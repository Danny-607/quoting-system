@extends('layouts.front-navigation')

@section('content')
<div class="form-container">
    <div class="form-card">
        <h2>{{ __('Login') }}</h2>
        <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
            @csrf

            <div class="description-container">
                <label for="email">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="input-field" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="description-container">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" class="input-field" name="password" required autocomplete="current-password">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="checkbox-container">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <div class="login-container">
                <button type="submit" class="btn">{{ __('Login') }}</button>
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
