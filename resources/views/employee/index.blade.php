@extends('layouts.dashboard')
@section('title', 'Employees')
@section('content')
@can('manage employees')

    <table>
        <thead>
            <tr>
                <th>User Name</th>
                <th>Contracted Hours</th>
                <th>Contracted Days</th>
                <th>Wage Type</th>
                <th>Wages</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->user->first_name }} {{ $employee->user->last_name }}</td>
                    <td>{{ $employee->contracted_hours }}</td>
                    <td>{{ $employee->contracted_days }}</td>
                    <td>{{ $employee->wage_type }}</td>
                    <td>£{{ $employee->wage_amount }}</td>
                    <td>
                        <div class="action-buttons">
                            <a class="edit-btn btn" href="{{ route('employees.edit', $employee->id) }}">Edit</a>
                            <form method="POST" action="{{ route('employees.destroy', $employee->id) }}"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="delete-btn btn" type="submit"
                                    onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a class="create-btn btn" href="{{ Route('employees.create') }}">Add a new employee</a>
    @endcan
@endsection
