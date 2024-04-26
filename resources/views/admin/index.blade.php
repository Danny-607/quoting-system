{{-- Extends the main dashboard layout to ensure consistent interface and functionality across the admin interface --}}
@extends('layouts.dashboard')

{{-- Sets the title of the page within the dashboard, which is 'Dashboard' --}}
@section('title', 'Dashboard')

{{-- Begins defining the content section of the page --}}
@section('content')

    {{-- Permission check to ensure only users authorized to view the admin dashboard can access this view --}}
    @can('view admin dashboard')

        {{-- Main header for the admin dashboard --}}
        <h1>Admin Dashboard</h1>
        <h2>Manage Users</h2>

        {{-- Table to display user details --}}
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>  {{-- Column header for user names --}}
                        <th>Email</th>  {{-- Column header for user emails --}}
                        <th>Role</th>  {{-- Column header for user roles --}}
                        <th>Actions</th>  {{-- Column header for actions like edit or delete --}}
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop through each user and display their information --}}
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->roles->pluck('name')->join(', ') }}</td>  {{-- Displaying all roles assigned to a user --}}
                            <td>
                                {{-- Action buttons for editing and deleting user records --}}
                                <div class="action-buttons">
                                    <a class="edit-btn btn" href="{{ Route('users.edit', $user->id) }}">Edit</a>
                                    <form method="POST" action="{{ route('users.destroy', $user->id) }}">
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

        {{-- Buttons to create new users or roles --}}
        <div class="btn-group">
            <a id="create-user-btn" class="create-btn btn" href="{{ route('users.create') }}">Create a new user</a>
            <a id="create-role-btn" class="create-btn btn" href="{{ route('roles.create') }}">Create a new role</a>
        </div>

        {{-- Success message display after an operation --}}
        @if (session()->has('success'))
            <p class="success-msg">{{ session('success') }}</p>
        @endif

        <h2>Roles and Permissions</h2>
        <section class="admin-card-container">
            {{-- Loop through each role and display its permissions --}}
            @foreach ($roles as $role)
                <div class="admin-card">
                    <h2>{{ strToUpper($role->name) }}</h2>
                    <ul>
                        {{-- Check if the role has permissions assigned --}}
                        @if ($role->permissions->isEmpty())
                            <li>No permissions assigned</li>
                        @else
                            {{-- Display all permissions assigned to the role --}}
                            @foreach ($role->permissions as $permission)
                                <li>{{ $permission->name }}</li>
                            @endforeach
                        @endif
                    </ul>
                    {{-- Buttons for editing and deleting roles --}}
                    <a class="edit-btn btn" href="{{ route('roles.edit', $role->id) }}">Edit</a>
                    <form action="{{ route('roles.destroy', $role->id) }}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn delete-btn" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            @endforeach
        </section>

    {{-- Ends the permission check --}}
    @endcan

{{-- Ends the content section of the blade template --}}
@endsection
