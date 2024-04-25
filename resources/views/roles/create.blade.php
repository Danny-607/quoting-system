@extends('layouts.dashboard')

@section('title', 'Create Role')

@section('content')
    <div class="form-container">
        <div class="card">
            <h1>Create Role</h1>
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <label for="name">Role Name:</label>
                <input type="text" id="name" name="name">


                <label>Assign Permissions:</label>
                @foreach ($permissions as $permission)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                            id="permission_{{ $permission->id }}">
                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                @endforeach

                <button type="submit" class="btn save-btn">Create Role</button>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p><strong>{{ $error }}</strong></p>
                    @endforeach
                @endif
        </div>
        </form>
    </div>
    </div>
@endsection
