{{-- Extends the front-navigation layout to maintain consistent styling and functionality across the customer interface --}}
@extends('layouts.front-navigation')

{{-- Sets the title of the page within the navigation layout, which is 'Dashboard' --}}
@section('title', 'Dashboard')

{{-- Begins defining the content section of the page --}}
@section('content')

    {{-- Permission check to ensure only users authorized to view the customer dashboard can access this view --}}
    @can('view customer dashboard')
    
        {{-- Main container for the dashboard content --}}
        <section class="dashboard-container">
            {{-- Header section for the dashboard --}}
            <header>
                <h1>Dashboard</h1>
            </header>

            {{-- Section for displaying unapproved quotes --}}
            <section class="quotes">
                <h2>Unapproved Quotes</h2>
                {{-- Loop through each unapproved quote and display its details --}}
                @foreach ($unapprovedQuotes as $quote)
                    <article class="card">
                        <div class="card-body">
                            {{-- Title for the quote card, showing quote number --}}
                            <h3 class="card-title">Quote #{{ $quote->id }}</h3>
                            {{-- Display the status of the quote --}}
                            <p class="card-text"><strong>Status:</strong> {{ $quote->status }}</p>
                            {{-- List all services associated with this quote --}}
                            <p class="card-text"><strong>Services:</strong>
                                @foreach ($quote->services as $service)
                                    <span class="badge">{{ $service->name }} (${{ number_format($service->price, 2) }})</span>
                                @endforeach
                            </p>
                            {{-- Display the total preliminary price of the quote --}}
                            <p class="card-text"><strong>Total Price:</strong> ${{ number_format($quote->preliminary_price, 2) }}</p>
                        </div>
                    </article>
                @endforeach
            </section>

            {{-- Section for displaying approved quotes --}}
            <section class="quotes">
                <h2>Approved Quotes</h2>
                {{-- Loop through each approved quote and display its details --}}
                @foreach ($approvedQuotes as $quote)
                    <article class="card">
                        <h3 class="card-title">Quote #{{ $quote->id }}</h3>
                        <p class="card-text"><strong>Status:</strong> {{ $quote->status }}</p>
                        <p class="card-text"><strong>Services:</strong>
                            @foreach ($quote->services as $service)
                                <span class="badge">{{ $service->name }} (${{ number_format($service->price, 2) }})</span>
                            @endforeach
                        </p>
                        {{-- Display the total price of the quote, summing up the prices of all services --}}
                        <p class="card-text"><strong>Total Price:</strong> ${{ number_format($quote->services->sum('price'), 2) }}</p>
                    </article>
                @endforeach
            </section>
        </section>

    {{-- Ends the permission check --}}
    @endcan

{{-- Ends the content section of the blade template --}}
@endsection
