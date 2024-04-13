@extends('layouts.dashboard')

@section('content')
@section('content')
    <div class="container">
        <h2>Projects</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Assigned Employees</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        
                        <td>{{ $project->quote->user->name }}</td>
                        <td>
                            <ul>
                                @foreach($project->employees as $employee)
                                    <li>{{ $employee->user->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@endsection