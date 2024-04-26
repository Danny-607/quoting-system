{{-- Extends the base dashboard layout to maintain consistent styling and functionality across the admin interface --}}
@extends('layouts.dashboard')

{{-- Sets the page title in the dashboard to "Edit Role" --}}
@section('title', 'Edit Role')

{{-- Starts defining the content section of the page --}}
@section('content')

    {{-- Container for the form, styled as a card to enhance visual appeal and layout consistency --}}
    <div class="form-container">
        <div class="card">
            {{-- Heading indicating the action of the form --}}
            <h1>Edit Role</h1>

            {{-- Form setup to submit updates to a role, targeting the 'roles.update' route with the specific role instance --}}
            <form action="{{ route('roles.update', $role) }}" method="POST">
                {{-- CSRF token for security, protecting against CSRF attacks --}}
                @csrf
                {{-- Method directive to specify that the HTTP request should be treated as PUT for updating resources --}}
                @method('PUT')

                {{-- Form group for role name input --}}
                <div class="form-group">
                    <label for="name">Role Name:</label>
                    <input type="text" id="name" name="name" value="{{ $role->name }}">
                </div>

                {{-- Form group for assigning permissions to the role --}}
                <div class="form-group">
                    <label>Assign Permissions:</label>
                    {{-- Loop through each permission and create a checkbox for each one --}}
                    @foreach ($permissions as $permission)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                   value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                                   {{-- Check the checkbox if the role currently has the permission --}}
                                   {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                {{-- Submit button to save the updates to the role --}}
                <button type="submit" class="btn edit-btn">Update Role</button>

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
