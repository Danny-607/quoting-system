@extends('layouts.dashboard')
@section('title', 'Create a user')
@section('content')
    <div class="form-container">
        <div class="card">
            <h1>Create New User</h1>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name">
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
                <select name="role" id="role">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                <button class="btn submit" type="submit">Create User</button>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p><strong>{{ $error }}</strong></p>
                    @endforeach
                @endif
            </form>
        </div>
    </div>
@endsection
