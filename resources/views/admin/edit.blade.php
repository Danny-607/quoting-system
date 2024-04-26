{{-- Extends the main dashboard layout to ensure consistent styling and functionality across the admin interface --}}
@extends('layouts.dashboard')

{{-- Sets the title of the page in the dashboard, which is 'Edit roles' --}}
@section('title', 'Edit roles')

{{-- Begins defining the content section of the page --}}
@section('content')

    {{-- Permission check to ensure only users authorized to manage roles can access this form --}}
    @can('manage roles')
    
        {{-- Container for the form, styled as a card to improve layout and aesthetics --}}
        <div class="form-container">
            <div class="card">
                {{-- Form setup to submit role assignments to the 'admin.role' route --}}
                <form action="{{ route('admin.role') }}" method="POST">
                    {{-- CSRF protection token to secure the form against CSRF attacks --}}
                    @csrf

                    {{-- Form group for selecting a user --}}
                    <div class="form-group">
                        <label for="user">Select User:</label>
                        <select name="user_id" id="user">
                            {{-- Loop through each user and create an option for them in the dropdown --}}
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                            @endforeach
                        </select>

                        {{-- Form group for selecting a role --}}
                        <label for="role">Select Role:</label>
                        <select name="role" id="role">
                            {{-- Loop through each role and create an option for them in the dropdown --}}
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>

                        {{-- Submission button to save the new role assignment --}}
                        <button type="submit">Submit</button>

                        {{-- Error handling: displays validation errors if any are present --}}
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <p><strong>{{ $error }}</strong></p>
                            @endforeach
                        @endif
                </form>
            </div>
        </div>

    {{-- Ends the permission check --}}
    @endcan

{{-- Ends the content section of the blade template --}}
@endsection
