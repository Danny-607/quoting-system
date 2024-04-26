{{-- Extends the master layout from the "layouts.dashboard" Blade file --}}
@extends('layouts.dashboard')

{{-- Sets the title of the page to "Create a User" --}}
@section('title', 'Create a user')

{{-- Defines the main content section for the page --}}
@section('content')

{{-- Checks if the currently authenticated user has the 'manage users' permission --}}
@can('manage users')

    {{-- Container div for the form --}}
    <div class="form-container">
        {{-- Card styling for the form --}}
        <div class="card">
            {{-- Heading for the form --}}
            <h1>Create New User</h1>

            {{-- Form for creating a new user, posts to the "users.store" route --}}
            <form action="{{ route('users.store') }}" method="POST">
                {{-- CSRF field to protect against cross-site request forgery --}}
                @csrf

                {{-- Input field for the user's first name --}}
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name">

                {{-- Input field for the user's last name --}}
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name">

                {{-- Input field for the user's phone number --}}
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number">

                {{-- Input field for the user's email address --}}
                <label for="email">Email:</label>
                <input type="email" name="email" id="email">

                {{-- Input field for the user's password --}}
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">

                {{-- Dropdown for selecting the user's role, populated from a list of roles --}}
                <select name="role" id="role">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>

                {{-- Submit button for the form --}}
                <button class="btn save-btn" type="submit">Create User</button>

                {{-- Error display block, shows errors if any are present during form validation --}}
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p><strong>{{ $error }}</strong></p>
                    @endforeach
                @endif
            </form>
        </div>
    </div>

{{-- End permission check --}}
@endcan

{{-- Ends the content section --}}
@endsection
