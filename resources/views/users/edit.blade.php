{{-- Extends the base dashboard layout --}}
@extends('layouts.dashboard')

{{-- Sets the title of the section, which is 'Edit a user' --}}
@section('title', 'Edit a user')

{{-- Begins the content section of the blade template --}}
@section('content')

{{-- Checks if the currently authenticated user has the 'manage users' permission --}}
@can('manage users')

    {{-- Container div for the form --}}
    <div class="form-container">
        {{-- Card styling for the form --}}
        <div class="card">
            {{-- Heading for the form, indicating it's for editing a user --}}
            <h1>Edit User</h1>

            {{-- Form setup for submitting user updates. Sends a PUT request to the 'users.update' route --}}
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                {{-- Specifies that the form method should be treated as PUT --}}
                @method('PUT')
                {{-- CSRF token for form protection against CSRF attacks --}}
                @csrf

                {{-- Input field for first name with prefilled current user's first name --}}
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" value="{{ $user->first_name }}" required>

                {{-- Input field for last name with prefilled current user's last name --}}
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" value="{{ $user->last_name }}" required>

                {{-- Input field for phone number with prefilled current user's phone number --}}
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number" value="{{ $user->phone_number }}" required>

                {{-- Input field for email with prefilled current user's email --}}
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" required>

                {{-- Input field for password, allowing for password change --}}
                <label for="password">New Password:</label>
                <input type="password" name="password" id="password">

                {{-- Dropdown for selecting the user's role, with options populated from roles in the database --}}
                <select name="role" id="role">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>

                {{-- Button to submit the form, triggering the user update --}}
                <button class="edit-btn btn" type="submit">Update User</button>

                {{-- Checks and displays any errors that occur during form submission --}}
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p><strong>{{ $error }}</strong></p>
                    @endforeach
                @endif
            </form>
        </div>
    </div>

{{-- End of the permission check --}}
@endcan

{{-- Ends the content section --}}
@endsection
