{{-- Extends the dashboard layout to maintain consistent styling and functionality across the admin interface --}}
@extends('layouts.dashboard')

{{-- Sets the page title in the dashboard to "Create an employee" --}}
@section('title', 'Create an employee')

{{-- Starts defining the content section of the page --}}
@section('content')

    {{-- Checks if the authenticated user has permission to manage employees --}}
    @can('manage employees')
    
        {{-- Container for the form, styled as a card for better visual appeal and layout consistency --}}
        <div class="form-container">
            <div class="card">
                {{-- Heading of the form indicating it's for creating a new employee --}}
                <h2>Create an employee</h2>

                {{-- Form setup to submit data to the 'employees.store' route --}}
                <form action="{{ Route('employees.store') }}" method="POST">
                    {{-- CSRF protection token --}}
                    @csrf
                    {{-- Method directive to specify that the HTTP request should be treated as POST --}}
                    @method('POST')

                    {{-- Dropdown menu to select a user to assign as an employee --}}
                    <label for="user_name">Select the user you want to assign to an employee</label>
                    <select name="user_name" id="user_name">
                        {{-- Loop through each user and create an option for them in the dropdown --}}
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                        @endforeach
                    </select>

                    {{-- Input for weekly contracted hours --}}
                    <label for="contracted_hours">Weekly contracted hours</label>
                    <input type="integer" name="contracted_hours">

                    {{-- Input for contracted days per week --}}
                    <label for="contracted_days">Contracted days a week</label>
                    <input type="integer" name="contracted_days">

                    {{-- Dropdown menu for selecting the wage type: hourly or salary --}}
                    <label for="wage_type">Hourly or salary</label>
                    <select name="wage_type" id="wage_type">
                        <option value="hourly">Hourly</option>
                        <option value="salary">Salary</option>
                    </select>

                    {{-- Input for specifying the wages --}}
                    <label for="wages">Wages</label>
                    <input type="decimal" name="wages">

                    {{-- Submission button for the form --}}
                    <button class="btn save-btn" type="submit">Create Employee</button>

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
