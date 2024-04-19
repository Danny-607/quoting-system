@extends('layouts.dashboard')

@section('content')
{{-- <form action="{{ route('admin.role') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="user">Select User:</label>
        <select name="user_id" id="user">
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->first_name }}</option>
            @endforeach
        </select>
    <label for="role">Select Role:</label>
    <select name="role" id="role">
        @foreach ($roles as $role)
            <option value="{{ $role->name }}">{{ $role->name }}</option>
        @endforeach
    </select>
    <button type="submit">Submit</button>
</form> --}}

    <h2>Manage Users</h2>
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
                        <a class="edit-btn btn" href="{{Route('users.edit', $user->id)}}">Edit</a>
                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display: inline-block;">
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
    <a class="create-btn btn" href="{{route('users.create')}}">Create a new user</a>
    
    @if (session()->has('success'))
    <p class="success-msg">{{ session('success') }}</p>
@endif
@endsection