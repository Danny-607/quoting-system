@extends('layouts.dashboard')

@section('title', 'Edit Role')

@section('content')
    <div class="form-container">
        <div class="card">
            <h1>Edit Role</h1>
            <form action="{{ route('roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Role Name:</label>
                    <input type="text" id="name" name="name" value="{{ $role->name }}">
                </div>
                <div class="form-group">
                    <label>Assign Permissions:</label>
                    @foreach ($permissions as $permission)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                                {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn edit-btn">Update Role</button>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p><strong>{{ $error }}</strong></p>
                    @endforeach
                @endif
            </form>
        </div>
    </div>
@endsection
