{{-- Extends the main dashboard layout to ensure consistency in styling and functionality across the admin interface --}}
@extends('layouts.dashboard')

{{-- Starts defining the content section of the page --}}
@section('content')
<!-- Container div for the form, styled as a card for better layout and aesthetics -->
<div class="form-container">
    <div class="card">
        <!-- Heading of the form indicating it's for creating a new category -->
        <h1>Create Category</h1>
        
        <!-- Form setup to submit data to the 'categories.store' route -->
        <form method="POST" action="{{ route('categories.store') }}">
            <!-- CSRF protection token to secure the form against CSRF attacks -->
            @csrf
            
            <!-- Input field for entering the category name -->
            <label for="name">Category Name:</label>
            <input type="text" id="name" name="name" required>
            
            <!-- Dropdown menu for selecting the category type -->
            <label for="type">Category Type:</label>
            <select id="type" name="type">
                <option value="service">Service</option> <!-- Option for service type category -->
                <option value="running_cost">Running Costs</option> <!-- Option for running cost type category -->
            </select>
            
            <!-- Submission button to save the new category -->
            <button type="submit" class="btn save-btn">Create Category</button>
        </form>
    </div>
</div>
{{-- Ends the content section of the blade template --}}
@endsection
