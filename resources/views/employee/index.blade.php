{{-- Extends the main dashboard layout to ensure consistent interface and functionality across the admin interface --}}
@extends('layouts.dashboard')

{{-- Sets the title of the page in the dashboard, which is 'Employees' --}}
@section('title', 'Employees')

{{-- Starts defining the content section of the page --}}
@section('content')

    {{-- Permission check to ensure only users authorized to manage employees can access this view --}}
    @can('manage employees')

        {{-- Main header for the employees page --}}
        <h1>Employees</h1>

        {{-- Table to display employee details --}}
        <table>
            <thead>
                <tr>
                    <th>User Name</th>  {{-- Column header for employee names --}}
                    <th>Contracted Hours</th>  {{-- Column header for contracted hours per week --}}
                    <th>Contracted Days</th>  {{-- Column header for contracted days per week --}}
                    <th>Wage Type</th>  {{-- Column header for type of wage: hourly or salary --}}
                    <th>Wages</th>  {{-- Column header for wage amount --}}
                    <th>Actions</th>  {{-- Column header for actions like edit or delete --}}
                </tr>
            </thead>
            <tbody>
                {{-- Loop through each employee and display their information --}}
                @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->user->first_name }} {{ $employee->user->last_name }}</td>  {{-- Displaying the full name of the employee --}}
                        <td>{{ $employee->contracted_hours }}</td>  {{-- Displaying the contracted hours --}}
                        <td>{{ $employee->contracted_days }}</td>  {{-- Displaying the contracted days --}}
                        <td>{{ $employee->wage_type }}</td>  {{-- Displaying the wage type (hourly/salary) --}}
                        <td>£{{ $employee->wage_amount }}</td>  {{-- Displaying the wage amount --}}
                        <td>
                            {{-- Action buttons for editing and deleting employee records --}}
                            <div class="action-buttons">
                                {{-- Edit button with a link to the employee edit route --}}
                                <a class="edit-btn btn" href="{{ route('employees.edit', $employee->id) }}">Edit</a>
                                {{-- Delete form with CSRF protection and DELETE method --}}
                                <form method="POST" action="{{ route('employees.destroy', $employee->id) }}"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    {{-- Delete button with a confirmation dialog --}}
                                    <button class="delete-btn btn" type="submit"
                                        onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Link to add a new employee --}}
        <a class="create-btn btn" href="{{ Route('employees.create') }}">Add a new employee</a>

    {{-- Ends the permission check --}}
    @endcan

{{-- Ends the content section of the blade template --}}
@endsection
