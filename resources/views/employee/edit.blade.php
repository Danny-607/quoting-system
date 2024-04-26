{{-- Extends the main dashboard layout to maintain a consistent interface and functionality --}}
@extends('layouts.dashboard')

{{-- Sets the title of the page in the dashboard --}}
@section('title', 'Edit an employee')

{{-- Starts defining the content section of the page --}}
@section('content')

    {{-- Permission check to ensure only users authorized to manage employees can access this form --}}
    @can('manage employees')

        {{-- Container for the form, styled as a card for better layout and aesthetics --}}
        <div class="form-container">
            <div class="card">
                {{-- Heading indicating the purpose of the form --}}
                <h2>Edit an employee</h2>

                {{-- Form setup to submit updates to an employee, targeting the 'employees.update' route --}}
                <form method="POST" action="{{ route('employees.update', $employee->id) }}">
                    {{-- CSRF protection token to secure the form against CSRF attacks --}}
                    @csrf
                    {{-- Method directive to specify that the HTTP request should be treated as a PUT --}}
                    @method('PUT')

                    {{-- Input for editing the number of contracted hours --}}
                    <label for="contracted_hours">Contracted Hours:</label>
                    <input type="number" id="contracted_hours" name="contracted_hours"
                           value="{{ old('contracted_hours', $employee->contracted_hours) }}">

                    {{-- Dropdown menu for selecting the wage type (hourly or salary) --}}
                    <label for="wage_type">Wage Type:</label>
                    <select id="wage_type" name="wage_type">
                        <option value="hourly" {{ old('wage_type', $employee->wage_type) === 'hourly' ? 'selected' : '' }}>
                            Hourly
                        </option>
                        <option value="salary" {{ old('wage_type', $employee->wage_type) === 'salary' ? 'selected' : '' }}>
                            Salary
                        </option>
                    </select>

                    {{-- Input for editing the wage amount --}}
                    <label for="wages">Wages:</label>
                    <input type="decimal" id="wages" name="wage_amount" value="{{ old('wages', $employee->wage_amount) }}">

                    {{-- Submission button to save the updated employee details --}}
                    <button class="btn edit-btn" type="submit">Update Employee</button>

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
