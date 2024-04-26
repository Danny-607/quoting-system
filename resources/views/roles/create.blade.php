{{-- Extends the dashboard layout to ensure consistent styling and functionality across the admin interface --}}
@extends('layouts.dashboard')

{{-- Sets the title of the page within the dashboard, which is 'Create Role' --}}
@section('title', 'Create Role')

{{-- Starts defining the content section of the page --}}
@section('content')

    {{-- Container for the form, styled as a card for aesthetic and layout consistency --}}
    <div class="form-container">
        <div class="card">
            {{-- Heading indicating the action of the form --}}
            <h1>Create Role</h1>

            {{-- Form setup for creating a new role, with data being posted to the 'roles.store' route --}}
            <form action="{{ route('roles.store') }}" method="POST">
                {{-- CSRF token for security, protecting against CSRF attacks --}}
                @csrf

                {{-- Input field for entering the name of the role --}}
                <label for="name">Role Name:</label>
                <input type="text" id="name" name="name">

                {{-- Section to assign permissions to the role --}}
                <label>Assign Permissions:</label>
                {{-- Loop through each permission and create a checkbox for assigning it to the role --}}
                @foreach ($permissions as $permission)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                               id="permission_{{ $permission->id }}">
                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                @endforeach

                {{-- Submit button for the form --}}
                <button type="submit" class="btn save-btn">Create Role</button>

                {{-- Error handling block: displays validation errors if any are present --}}
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p><strong>{{ $error }}</strong></p>
                    @endforeach
                @endif
            </form>
        </div>
    </div>

{{-- Ends the content section of the blade template --}}
@endsection
