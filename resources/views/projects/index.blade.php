@extends('layouts.dashboard')

@section('content')
@section('content')
<h2>Projects</h2>
<table class="table">
    <thead>
        <tr>
            <th>Client</th>
            <th>Services</th>
            <th>Assigned Employees</th>
            <th>Project Cost</th>
            <th>Project Revenue</th>
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $project)
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
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
@endsection