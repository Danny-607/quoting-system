@extends('layouts.front-navigation')
@section('title', 'Dashboard')
@section('content')
    <div class="container">
        <h1>Dashboard</h1>
        <div class="row">
            <h2>Unapproved Quotes</h2>
            @foreach ($unapprovedQuotes as $quote)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quote #{{ $quote->id }}</h5>
                        <p class="card-text"><strong>Status:</strong> {{ $quote->status }}</p>
                        <p class="card-text"><strong>Services:</strong>
                            @foreach ($quote->services as $service)
                                <span class="badge">{{ $service->name }} (${{ $service->price }})</span>
                            @endforeach
                        </p>
                        <p class="card-text"><strong>Total Price:</strong> ${{ $quote->services->sum('price') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <h2>Approved Quotes</h2>
        @foreach ($approvedQuotes as $quote)
            <div class="card">
                <h5 class="card-title">Quote #{{ $quote->id }}</h5>
                <p class="card-text"><strong>Status:</strong> {{ $quote->status }}</p>
                <p class="card-text"><strong>Services:</strong>
                    @foreach ($quote->services as $service)
                        <span class="badge">{{ $service->name }} (${{ $service->price }})</span>
                    @endforeach
                </p>
                <p class="card-text"><strong>Total Price:</strong> ${{ $quote->services->sum('price') }}</p>
            </div>
        @endforeach
    </div>
    </div>
    </div>
@endsection
