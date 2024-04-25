@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
    @can('view admin dashboard')

        <h1>Admin Dashboard</h1>
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
                                        >
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
        <div class="btn-group">
            <a id="create-user-btn" class="create-btn btn" href="{{ route('users.create') }}">Create a new user</a>
            <a id="create-role-btn" class="create-btn btn" href="{{ route('roles.create') }}">Create a new role</a>
        </div>



        @if (session()->has('success'))
            <p class="success-msg">{{ session('success') }}</p>
        @endif
        <h2>Roles and Permissions</h2>
        <section class="admin-card-container">
            @foreach ($roles as $role)
                <div class="admin-card">
                    <h2>{{ strToUpper($role->name) }}</h2>
                    <ul class="">
                        @if ($role->permissions->isEmpty())
                            <li class="">No permissions assigned</li>
                        @else
                            @foreach ($role->permissions as $permission)
                                <li class="">{{ $permission->name }}</li>
                            @endforeach
                        @endif
                    </ul>
                    <a class="edit-btn btn" href="{{ route('roles.edit', $role->id) }}">Edit</a>
                    <form action="{{ route('roles.destroy', $role->id) }}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn delete-btn" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>

                </div>
                </div>
            @endforeach

            </div>
        </section>
    @endcan
@endsection
