{{-- Extends the base layout from the "layouts.dashboard" to maintain consistent styling and functionality across the admin interface --}}
@extends('layouts.dashboard')

{{-- Sets the title of the page to "Edit a quote" in the dashboard --}}
@section('title', 'Edit a quote')

{{-- Starts defining the content section for the page --}}
@section('content')

    {{-- Permission check to ensure only users with the capability to manage quotes can access this form --}}
    @can('manage quotes')
    
        {{-- Container for the form, styled as a card for visual appeal and layout consistency --}}
        <div class="form-container">
            <div class="card">
                {{-- Heading of the form indicating it's for editing a quote --}}
                <h2>Edit quote</h2>

                {{-- Form setup to submit updates to a quote, targeting the 'quotes.update' route with the specific quote instance --}}
                <form action="{{ route('quotes.update', $quote->id) }}" method="POST">
                    {{-- CSRF protection token --}}
                    @csrf
                    {{-- Method directive to specify that the HTTP request should be treated as PUT --}}
                    @method('PUT')

                    {{-- Textarea for editing the description of the quote, pre-filled with the existing description --}}
                    <label for="description">Description</label>
                    <textarea name="description" required>{{ $quote->description }}</textarea>

                    {{-- Input field for editing the preliminary price of the quote, pre-filled with the existing price --}}
                    <label for="preliminary_price">Preliminary Price</label>
                    <input type="number" name="preliminary_price" value="{{ $quote->preliminary_price }}" required>

                    {{-- Dropdown for selecting the approval status of the quote, with the current status pre-selected --}}
                    <label for="status">Approved</label>
                    <select name="status" required>
                        <option value="approved" {{ $quote->status === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="unapproved" {{ $quote->status === 'unapproved' ? 'selected' : '' }}>Unapproved</option>
                    </select>

                    {{-- Submit button to save the changes made to the quote --}}
                    <button class="btn edit-btn" type="submit">Edit Quote</button>

                    {{-- Error handling block: displays validation errors if any are present --}}
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
