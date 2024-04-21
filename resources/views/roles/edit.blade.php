@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
    @can('manage roles')

        <div class="container">
            <h1>Edit Role</h1>
            <form action="{{ route('roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Role Name:</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}" required>
                </div>
                <div class="form-group">
                    <h3>Assign Permissions</h3>
                    @foreach ($permissions as $permission)
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                id="permission_{{ $permission->id }}"
                                {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                            <label for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Update Role</button>
            </form>
        </div>
    @endcan
@endsection
