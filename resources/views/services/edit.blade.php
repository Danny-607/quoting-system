{{-- Extends the dashboard layout to ensure consistency across the admin interface --}}
@extends('layouts.dashboard')

{{-- Sets the title of the page in the dashboard to "Edit a service" --}}
@section('title', 'Edit a service')

{{-- Begins the content section for the page --}}
@section('content')

    {{-- Permission check to ensure only users with the capability to manage services can access this page --}}
    @can('manage services')

        {{-- Container for the form, styled as a card for better UI appearance --}}
        <div class="form-container">
            <div class="card">
                {{-- Form heading --}}
                <h2>Edit a service</h2>

                {{-- Form for submitting service updates. Utilizes POST method but specifies PUT via method directive --}}
                <form action="{{ route('services.update', ['service' => $service->id]) }}" method="post">
                    {{-- CSRF token to protect against cross-site request forgery --}}
                    @csrf
                    {{-- Override the HTTP method to 'PUT' for RESTful updating --}}
                    @method('put')

                    {{-- Text input for the service's name, pre-filled with the existing name or old input if validation fails --}}
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="service_name" value="{{ old('name', $service->name) }}">

                    {{-- Number input for the cost of the service, with steps to allow decimal values, pre-filled with existing or old input --}}
                    <label for="cost">Cost:</label>
                    <input type="number" name="cost" id="service_cost" 
                        value="{{ old('cost', $service->cost) }}">

                    {{-- Number input for the price at which the service is sold, similar to cost input, pre-filled with existing or old input --}}
                    <label for="price">Price:</label>
                    <input type="number" name="price" id="service_price" 
                        value="{{ old('price', $service->price) }}">

                    {{-- Dropdown for selecting the category of the service, with the current category pre-selected --}}
                    <label for="category_id">Category:</label>
                    <select name="category_id" id="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $service->service_category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Button to submit the form and save the updates --}}
                    <button class="btn edit-btn" type="submit">Update Service</button>

                    {{-- Error handling: checks if there are any validation errors and displays them --}}
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
