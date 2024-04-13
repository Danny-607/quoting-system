@extends('layouts.dashboard')

@section('content')


    <h1>Create Project</h1>
    <form action="{{ route('projects.store') }}" method="POST" id="project_form">
        @csrf

        <input type="hidden" name="quote_id" value="{{ $initialData['quote_id'] }}">

            <label for="user_name">User Name</label>
            <input type="text" class="" id="user_name" value="{{ $initialData['user_name'] }}" disabled>
        

            <label for="services">Services</label>
            <textarea class="" id="services" disabled>{{ $initialData['services'] }}</textarea>
        

            <label for="start_date">Start Date</label>
            <input type="date" class="" name="start_date" required>
        

            <label for="end_date">End Date</label>
            <input type="date" class="" name="expected_end_date" required>
        
        
            <label for="employees">Assign Employees</label>
            
            @livewire('add-employee')
        <button type="submit" class="">Create Project</button>
    </form>

@endsection