@extends('layouts.dashboard')
@section('title', 'Edit a project')
@section('content')
<div class="form-container">
    <div class="card">
    <h1>Edit Project</h1>

    <form action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="start_date">Start Date</label>
        <input type="date" name="start_date" value="{{ $project->start_date }}" required>

        <label for="expected_end_date">Expected End Date</label>
        <input type="date" name="expected_end_date" value="{{ $project->expected_end_date }}" required>

        <label for="actual_end_date">Actual End Date</label>
        <input type="date" name="actual_end_date" value="{{ $project->actual_end_date }}">

        <label for="project_cost">Project Cost</label>
        <input type="number" name="project_cost" value="{{ $project->project_cost }}" step="0.01" required>

        <label for="project_revenue">Project Revenue</label>
        <input type="number" name="project_revenue" value="{{ $project->project_revenue }}" step="0.01">

        <label for="status">Status</label>
        <select name="status" required>
            <option value="ongoing" {{ $project->status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
            <option value="completed" {{ $project->status === 'completed' ? 'selected' : '' }}>Completed</option>
        </select>

        <button type="submit">Update Project</button>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p><strong>{{ $error }}</strong></p>
            @endforeach
        @endif
    </form>
    </div>
</div>
@endsection
