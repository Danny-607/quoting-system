{{-- Extends the front-navigation layout to maintain consistent styling and functionality across the front-facing interface --}}
@extends('layouts.front-navigation')

{{-- Sets the title of the page within the navigation layout to "Get a quote" --}}
@section('title', 'Get a quote')

{{-- Starts defining the content section of the page --}}
@section('content')

    {{-- Checks if the authenticated user has permission to create quotes --}}
    @can('create quotes')

        {{-- Container for the form, styled as a card to improve aesthetic appeal and layout consistency --}}
        <div class="form-container">
            <div class="form-card">
                {{-- Heading indicating the purpose of the form --}}
                <h2>Select from a wide range of services</h2>

                {{-- Form setup to post data to the 'quotes.store' route --}}
                <form action="{{ route('quotes.store') }}" method="POST">
                    {{-- CSRF token for security, protecting against CSRF attacks --}}
                    @csrf

                    {{-- Loop through each category and display associated services --}}
                    @foreach ($categories as $category)
                        <div class="category-section">
                            {{-- Display the category name --}}
                            <h3>{{ $category->name }}</h3>
                            <div class="services-container">
                                {{-- Loop through each service within the category --}}
                                @foreach ($category->services as $service)
                                    <label class="service-box">
                                        {{-- Checkbox for selecting the service, storing the service's ID as the value --}}
                                        <input type="checkbox" name="services[]" value="{{ $service->id }}">
                                        <div class="box-content">
                                            {{-- Display the service name and price formatted as currency --}}
                                            {{ $service->name }} - £{{ number_format($service->price, 2) }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    {{-- Container for additional information input, where users can specify more details about their quote request --}}
                    <div class="description-container">
                        <label for="description">Additional information <br>(Example: blue colour theme and the website is based around animals.):</label>
                        <textarea name="description" id="description" cols="30" rows="5"></textarea>
                        <button type="submit">Submit</button>
                    </div>

                    {{-- Error handling: displays validation errors if any are present --}}
                    @if ($errors->any())
                        @foreach ($errors.all() as $error)
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
