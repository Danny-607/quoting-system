@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
    <h2>Manage Users</h2>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a class="edit-btn btn" href="{{ Route('users.edit', $user->id) }}">Edit</a>
                                <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete-btn btn" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a class="create-btn btn" href="{{ route('users.create') }}">Create a new user</a>

    @if (session()->has('success'))
        <p class="success-msg">{{ session('success') }}</p>
    @endif
@endsection
