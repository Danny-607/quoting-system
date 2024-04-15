@extends('layouts.dashboard')

@section('content')
    <h2>On Going Projects</h2>
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
                @foreach($projects as $project)
                    @if ($project->status == "ongoing" & $project->quote->status =="approved")
                    <tr>
                        <td>{{ $project->quote->user->name }}</td>
                        <td>
                            <ul>
                                @foreach($project->quote->services as $service)
                                    <li>{{ $service->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach($project->employees as $employee)
                                    <li>{{ $employee->user->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $project->project_cost }}</td>
                        <td>{{ $project->project_revenue }}</td>
                        <td>{{$project->expected_end_date}}</td>
                        <td>
                            <form action="{{ route('projects.complete', $project->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">Complete Project</button>
                            </form>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Services</th>
                    <th>Assigned Employees</th>
                    <th>Project Cost</th>
                    <th>Project Revenue</th>
                    <th>Date completed</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($projects as $project)
                        @if ($project->status == "completed")
                        <tr>
                            <td>{{ $project->quote->user->name }}</td>
                            <td>
                                <ul>
                                    @foreach($project->quote->services as $service)
                                        <li>{{ $service->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach($project->employees as $employee)
                                        <li>{{ $employee->user->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $project->project_cost }}</td>
                            <td>{{ $project->project_revenue }}</td>
                            <td>{{$project->actual_end_date}}</td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
@endsection
