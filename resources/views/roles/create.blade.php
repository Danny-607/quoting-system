@extends('layouts.app')

@section('title', 'Create New Role')

@section('content')
    <div class="container">
        <h1>Create New Role</h1>
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Role Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <h3>Assign Permissions</h3>
                @foreach($permissions as $permission)
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Create Role</button>
        </form>
    </div>
@endsection
