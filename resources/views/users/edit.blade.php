@extends('layouts.dashboard')
@section('title', 'Edit a user')
@section('content')
    <div class="container">
        <h1>Edit User</h1>
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @method('PUT')
            @csrf
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" value="{{ $user->first_name }}" required>
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" value="{{ $user->last_name }}" required>
            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" value="{{ $user->phone_number }}" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ $user->email }}" required>
            <label for="password">New Password (leave blank if not changing):</label>
            <input type="password" name="password" id="password">
            <select name="role" id="role">
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
            <button class="edit-btn btn" type="submit">Update User</button>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <p><strong>{{ $error }}</strong></p>
                @endforeach
            @endif
        </form>
    </div>

@endsection
