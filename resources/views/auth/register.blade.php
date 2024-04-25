@extends('layouts.front-navigation')

@section('content')
<div class="form-container">
    <div class="form-card">
        <h2>{{ __('Register') }}</h2>
        <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
            @csrf

            <div class="description-container">
                <label for="first_name">{{ __('First Name') }}</label>
                <input id="first_name" type="text" class="input-field" name="first_name" value="{{ old('first_name') }}" required autofocus>
                @error('first_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="description-container">
                <label for="last_name">{{ __('Last Name') }}</label>
                <input id="last_name" type="text" class="input-field" name="last_name" value="{{ old('last_name') }}" required>
                @error('last_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="description-container">
                <label for="phone_number">{{ __('Phone Number') }}</label>
                <input id="phone_number" type="text" class="input-field" name="phone_number" value="{{ old('phone_number') }}" required>
                @error('phone_number')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="description-container">
                <label for="email">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="input-field" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="description-container">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" class="input-field" name="password" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="description-container">
                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="input-field" name="password_confirmation" required>
            </div>
            <div class="login-container">
                <div class="button-group">
                    <button type="submit" class="btn">{{ __('Register') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
