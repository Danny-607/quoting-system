@extends('layouts.front-navigation')
@section('title', 'Dashboard')
@section('content')
@can('view customer dashboard')
    
    <section class="dashboard-container">
        <header>
            <h1>Dashboard</h1>
        </header>

        <section>
            <h2>Unapproved Quotes</h2>
            @foreach ($unapprovedQuotes as $quote)
                <article class="card">
                    <div class="card-body">
                        <h3 class="card-title">Quote #{{ $quote->id }}</h3>
                        <p class="card-text"><strong>Status:</strong> {{ $quote->status }}</p>
                        <p class="card-text"><strong>Services:</strong>
                            @foreach ($quote->services as $service)
                                <span class="badge">{{ $service->name }} (${{ $service->price }})</span>
                            @endforeach
                        </p>
                        <p class="card-text"><strong>Total Price:</strong> ${{ $quote->preliminary_price }}</p>
                    </div>
                </article>
            @endforeach
        </section>

        <section>
            <h2>Approved Quotes</h2>
            @foreach ($approvedQuotes as $quote)
                <article class="card">
                    <h3 class="card-title">Quote #{{ $quote->id }}</h3>
                    <p class="card-text"><strong>Status:</strong> {{ $quote->status }}</p>
                    <p class="card-text"><strong>Services:</strong>
                        @foreach ($quote->services as $service)
                            <span class="badge">{{ $service->name }} (${{ $service->price }})</span>
                        @endforeach
                    </p>
                    <p class="card-text"><strong>Total Price:</strong> ${{ $quote->services->sum('price') }}</p>
                </article>
            @endforeach
        </section>
    </section>
@endcan
@endsection
