{{-- Extends the main dashboard layout to ensure consistent styling and functionality across the admin interface --}}
@extends('layouts.dashboard')

{{-- Sets the title of the page within the dashboard, which is 'Edit a project' --}}
@section('title', 'Edit a project')

{{-- Begins defining the content section of the page --}}
@section('content')

    {{-- Checks if the authenticated user has permission to manage projects --}}
    @can('manage projects')

        {{-- Container for the form, styled as a card to improve visual appeal and layout consistency --}}
        <div class="form-container">
            <div class="card">
                {{-- Heading indicating the action of the form --}}
                <h1>Edit Project</h1>

                {{-- Form setup to submit updates to a project, targeting the 'projects.update' route with the specific project instance --}}
                <form action="{{ route('projects.update', $project->id) }}" method="POST">
                    {{-- CSRF protection token --}}
                    @csrf
                    {{-- Method directive to specify that the HTTP request should be treated as PUT --}}
                    @method('PUT')

                    {{-- Input field for selecting the start date of the project --}}
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" value="{{ $project->start_date }}" required>

                    {{-- Input field for selecting the expected end date of the project --}}
                    <label for="expected_end_date">Expected End Date</label>
                    <input type="date" name="expected_end_date" value="{{ $project->expected_end_date }}" required>

                    {{-- Input field for selecting the actual end date of the project (if applicable) --}}
                    <label for="actual_end_date">Actual End Date</label>
                    <input type="date" name="actual_end_date" value="{{ $project->actual_end_date }}">

                    {{-- Input field for entering the project cost --}}
                    <label for="project_cost">Project Cost</label>
                    <input type="number" name="project_cost" value="{{ $project->project_cost }}" step="0.01" required>

                    {{-- Input field for entering the project revenue --}}
                    <label for="project_revenue">Project Revenue</label>
                    <input type="number" name="project_revenue" value="{{ $project->project_revenue }}" step="0.01">

                    {{-- Dropdown for selecting the status of the project --}}
                    <label for="status">Status</label>
                    <select name="status" required>
                        <option value="ongoing" {{ $project->status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ $project->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>

                    {{-- Submission button for the form to save the updated project details --}}
                    <button class="btn edit-btn" type="submit">Update Project</button>

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
