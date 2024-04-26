{{-- Extends the dashboard layout to maintain consistent styling and structure across the admin interface --}}
@extends('layouts.dashboard')

{{-- Sets the page title in the dashboard to "Edit a running cost" --}}
@section('title', 'Edit a running cost')

{{-- Starts defining the content section for the page --}}
@section('content')

    {{-- Checks if the authenticated user has the permission to manage running costs --}}
    @can('manage running costs')

        {{-- Container for the form with a class that styles it as a card --}}
        <div class="form-container">
            <div class="card">
                {{-- Form heading indicating the purpose of the form --}}
                <h2>Edit Running Cost</h2>

                {{-- Form set up to submit data to the 'runningcosts.update' route for the specific running cost --}}
                <form action="{{ route('runningcosts.update', ['runningcost' => $runningCost->id]) }}" method="post">
                    {{-- CSRF protection token --}}
                    @csrf
                    {{-- Method directive to specify that the HTTP request should be treated as a PUT --}}
                    @method('put')

                    {{-- Input field for the name of the running cost, pre-filled with existing data --}}
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="{{ $runningCost->name }}">

                    {{-- Input field for the cost, allowing decimal values, pre-filled with existing data --}}
                    <label for="cost">Cost</label>
                    <input type="number" name="cost" id="cost" step="0.01" value="{{ $runningCost->cost }}">

                    {{-- Date input for the date the cost was incurred, pre-filled with existing data --}}
                    <label for="date_incurred">Date Incurred</label>
                    <input type="date" name="date_incurred" id="date_incurred" value="{{ $runningCost->date_incurred }}">

                    {{-- Dropdown for selecting the category of the running cost, with the current category pre-selected --}}
                    <label for="category">Category</label>
                    <select name="category_id" id="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $runningCost->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Checkbox for marking the cost as repeating, checked if it is currently set to repeating --}}
                    <label for="repeating">Repeating</label>
                    <input type="checkbox" name="repeating" id="repeating" value="1"
                        {{ $runningCost->repeating ? 'checked' : '' }}>

                    {{-- Submit button for the form to update the running cost --}}
                    <button class="btn edit-btn" type="submit">Update Running Cost</button>

                    {{-- Displays validation errors if there are any after form submission --}}
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p><strong>{{ $error }}</strong></p>
                        @endforeach
                    @endif
                </form>
            </div>
        </div>

    {{-- Ends the section for managing content --}}
    @endsection

{{-- Ends the permission check --}}
@endcan
