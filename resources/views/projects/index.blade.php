{{-- Extends the main dashboard layout to ensure consistent styling and functionality across the admin interface --}}
@extends('layouts.dashboard')

{{-- Sets the page title in the dashboard, which is 'Projects overview' --}}
@section('title', 'Projects overview')

{{-- Begins defining the content section of the page --}}
@section('content')

    {{-- Permission check to ensure only users authorized to manage projects can access this view --}}
    @can('manage projects')

        {{-- Main header for the projects page --}}
        <h1>Projects</h1>

        {{-- Subheader for ongoing projects --}}
        <h2>On Going Projects</h2>
        
        {{-- Table to display ongoing projects --}}
        <table class="table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Services</th>
                    <th>Assigned Employees</th>
                    <th>Project Cost</th>
                    <th>Project Revenue</th>
                    <th>Expected end date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop through each project and filter for ongoing ones --}}
                @foreach ($projects as $project)
                    @if (($project->status == 'ongoing') & ($project->quote->status == 'approved'))
                        <tr>
                            {{-- Display client's name, services list, assigned employees, cost, revenue, and expected end date --}}
                            <td>{{ $project->quote->user->first_name }} {{ $project->quote->user->last_name }}</td>
                            <td>
                                <ul>
                                    {{-- Loop through services linked to the quote of the project --}}
                                    @foreach ($project->quote->services as $service)
                                        <li>{{ $service->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    {{-- List employees assigned to this project --}}
                                    @foreach ($project->employees as $employee)
                                        <li>{{ $employee->user->first_name }} {{ $employee->user->last_name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $project->project_cost }}</td>
                            <td>{{ $project->project_revenue }}</td>
                            <td>{{ $project->expected_end_date }}</td>
                            <td>
                                <div class="action-buttons">
                                    {{-- Forms and buttons for project completion, deletion, and editing --}}
                                    <form action="{{ route('projects.complete', $project->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn save-btn">Complete Project</button>
                                    </form>
                                    <form method="POST" action="{{ route('projects.destroy', $project->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="delete-btn btn" type="submit">Delete</button>
                                    </form>
                                    <a class="edit-btn btn" href="{{Route('projects.edit', $project->id)}}">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        {{-- Subheader for completed projects --}}
        <h2>Completed projects</h2>
        
        {{-- Table to display completed projects --}}
        <table class="table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Services</th>
                    <th>Assigned Employees</th>
                    <th>Project Cost</th>
                    <th>Project Revenue</th>
                    <th>Date completed</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop through each project and filter for completed ones --}}
                @foreach ($projects as $project)
                    @if ($project->status == 'completed')
                        <tr>
                            {{-- Display client's name, services list, assigned employees, cost, revenue, and completion date --}}
                            <td>{{ $project->quote->user->first_name }} {{ $project->quote->user->last_name }}</td>
                            <td>
                                <ul>
                                    @foreach ($project->quote->services as $service)
                                        <li>{{ $service->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach ($project->employees as $employee)
                                        <li>{{ $employee->user->first_name }} {{ $employee->user->last_name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $project->project_cost }}</td>
                            <td>{{ $project->project_revenue }}</td>
                            <td>{{ $project->actual_end_date }}</td>
                            <td>
                                <div class="action-buttons">
                                    {{-- Form and button for deleting the project and link for editing --}}
                                    <form method="POST" action="{{ route('projects.destroy', $project->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="delete-btn btn" type="submit">Delete</button>
                                    </form>
                                    <a class="edit-btn btn" href="{{Route('projects.edit', $project->id)}}">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

    {{-- Ends the permission check --}}
    @endcan

{{-- Ends the content section of the blade template --}}
@endsection
