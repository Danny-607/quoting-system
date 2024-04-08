@extends('layouts.dashboard')

@section('content')
<form method="POST" action="{{ route('employees.update', $employee->id) }}">
    @csrf
    @method('PUT')

    <!-- Add input fields for editing employee information -->
    <label for="contracted_hours">Contracted Hours:</label>
    <input type="number" id="contracted_hours" name="contracted_hours" value="{{ old('contracted_hours', $employee->contracted_hours) }}">

    <label for="wage_type">Wage Type:</label>
    <select id="wage_type" name="wage_type">
        <option value="hourly" {{ old('wage_type', $employee->wage_type) === 'hourly' ? 'selected' : '' }}>Hourly</option>
        <option value="salary" {{ old('wage_type', $employee->wage_type) === 'salary' ? 'selected' : '' }}>Salary</option>
    </select>

    <label for="wages">Wages:</label>
    <input type="decimal" id="wages" name="wage_amount" value="{{ old('wages', $employee->wage_amount) }}">

    <button type="submit">Update Employee</button>
</form>
@endsection