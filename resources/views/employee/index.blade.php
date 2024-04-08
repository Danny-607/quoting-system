@extends('layouts.dashboard')

@section('content')
<table>
    <thead>
        <tr>
            <th>User Name</th>
            <th>Contracted Hours</th>
            <th>Wage Type</th>
            <th>Wages</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $employee)
        <tr>
            <td>{{ $employee->user->name }}</td>
            <td>{{ $employee->contracted_hours }}</td>
            <td>{{ $employee->wage_type }}</td>
            <td>{{ $employee->wage_amount }}</td>
            <td>
                <a href="{{ route('employees.edit', $employee->id) }}">Edit</a>
                <form method="POST" action="{{ route('employees.destroy', $employee->id) }}" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this employee?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


@endsection