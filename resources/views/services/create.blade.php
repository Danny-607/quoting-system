{{-- Extends the base layout from the "layouts.dashboard", integrating the dashboard's standard features and styles --}}
@extends('layouts.dashboard')

{{-- Sets the title of the page to "Create a service" --}}
@section('title', 'Create a service')

{{-- Starts defining the content section for the page --}}
@section('content')

{{-- Permission check to ensure only users who can manage services are able to access this form --}}
@can('manage services')
    
    {{-- Container for the form with a class for styling --}}
    <div class="form-container">
        {{-- Card design for the form interface --}}
        <div class="card">
            {{-- Heading for the form, indicating creation of a new service --}}
            <h2>Create a new service</h2>

            {{-- Form setup for creating a new service, posts to the "services.store" route --}}
            <form action="{{ route('services.store') }}" method="post">
                {{-- CSRF token for security, protecting against cross-site request forgery --}}
                @csrf

                {{-- Input field for the service name --}}
                <label for="name">Enter the name of the service:</label>
                <input type="text" name="name" id="service_name">

                {{-- Input field for the cost of the service, with a step value to allow decimal points --}}
                <label for="cost">Enter the cost of the service:</label>
                <input type="number" name="cost" id="service_cost" step="0.01">

                {{-- Input field for the price at which the service will be sold --}}
                <label for="price">Enter the price of the service:</label>
                <input type="number" name="price" id="service_price" step="0.01">

                {{-- Dropdown for selecting the category of the service from available categories --}}
                <label for="category_id">Select the category of the service:</label>
                <select name="category_id" id="service_category">
                    @foreach ($categories as $category)
                        {{-- Loop through each category and create an option in the dropdown --}}
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                {{-- Submission button for the form --}}
                <button class="btn save-btn" type="submit">Save a new service</button>

                {{-- Checks for any validation errors and displays them --}}
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

{{-- Ends the content section --}}
@endsection
