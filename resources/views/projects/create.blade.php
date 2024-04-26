{{-- Extends the dashboard layout to ensure consistent styling and functionality across the admin interface --}}
@extends('layouts.dashboard')

{{-- Sets the title of the page in the dashboard, which is 'Create a project' --}}
@section('title', 'Create a project')

{{-- Starts defining the content section of the page --}}
@section('content')

    {{-- Permission check to ensure only users authorized to manage projects can access this form --}}
    @can('manage projects')
    
        {{-- Container for the form, styled as a card for better visual appeal and organization --}}
        <div class="form-container">
            <div class="card">
                {{-- Heading of the form indicating the purpose of the form --}}
                <h1>Create Project</h1>

                {{-- Form setup to submit data to the 'projects.store' route --}}
                <form action="{{ route('projects.store') }}" method="POST" id="project_form">
                    {{-- CSRF token for security, protecting against CSRF attacks --}}
                    @csrf

                    {{-- Hidden input to store the quote ID that the project is related to --}}
                    <input type="hidden" name="quote_id" value="{{ $initialData['quote_id'] }}">

                    {{-- Display field for the user name associated with the project, disabled as it's not editable --}}
                    <label for="user_name">User Name</label>
                    <input type="text" id="user_name" value="{{ $initialData['user_name'] }}" disabled>

                    {{-- Display field for services associated with the project, disabled as it's not editable --}}
                    <label for="services">Services</label>
                    <textarea id="services" disabled>{{ $initialData['services'] }}</textarea>

                    {{-- Input field for selecting the start date of the project --}}
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" required>

                    {{-- Input field for selecting the expected end date of the project --}}
                    <label for="end_date">End Date</label>
                    <input type="date" name="expected_end_date" required>

                    {{-- Section to assign employees to the project --}}
                    <label for="employees">Assign Employees</label>
                    {{-- Livewire component to dynamically add employees to the project --}}
                    @livewire('add-employee')

                    {{-- Submission button for the form --}}
                    <button type="submit" class="btn save-btn">Create Project</button>

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
