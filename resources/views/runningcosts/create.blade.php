{{-- Extends the layout used for the dashboard to maintain consistent design and functionality --}}
@extends('layouts.dashboard')

{{-- Sets the title of the dashboard section to "Create a running cost" --}}
@section('title', 'Create a running cost')

{{-- Starts defining the content section of the page --}}
@section('content')

    {{-- Permission check to ensure that only users who can manage running costs can access this form --}}
    @can ('manage running costs')
    
        {{-- Container div for the form, styled as a card for visual segregation and aesthetic design --}}
        <div class="form-container">
            <div class="card">
                {{-- Heading of the form indicating the action it is designed for --}}
                <h2>Add Running Cost</h2>

                {{-- Form setup to post data to the 'runningcosts.store' route, which handles data storage --}}
                <form action="{{ Route('runningcosts.store') }}" method="POST">
                    {{-- CSRF token for security, protecting against CSRF attacks --}}
                    @csrf
                    {{-- Specifies that the form method should be treated as POST --}}
                    @method('POST')

                    {{-- Input field for the name of the running cost --}}
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>

                    {{-- Input field for the cost value with a step attribute to allow decimal values --}}
                    <label for="cost">Cost:</label>
                    <input type="number" id="cost" name="cost" step="0.01" required>

                    {{-- Input field for the date when the cost was incurred --}}
                    <label for="date_incurred">Date Incurred:</label>
                    <input type="date" id="date_incurred" name="date_incurred" required>

                    {{-- Dropdown to select the category of the running cost, populated from existing categories --}}
                    <label for="category">Category:</label>
                    <select name="category" id="category">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    {{-- Checkbox to indicate whether the cost is repeating --}}
                    <div class="checkbox-container">
                        <label for="repeating">Repeating:</label>
                        <input type="checkbox" id="repeating" name="repeating" value="1">
                    </div>

                    {{-- Submission button for the form --}}
                    <button class="btn save-btn" type="submit">Submit</button>

                    {{-- Error handling: displays validation errors if any exist --}}
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
