@extends('layouts.front-navigation')

@section('content')
    <form action="{{ route('quotes.store') }}" method="POST">
        @csrf
        @foreach ($categories as $category)
            <div class="category-section">
                <h3>{{ $category->name }}</h3>
                <div class="services-container">
                    @foreach ($category->services as $service)
                        <label class="service-box">
                            <input type="checkbox" name="services[]" value="{{ $service->id }}">
                            <div class="box-content">
                                {{ $service->name }} - £{{ number_format($service->price, 2) }}
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <label for="description">Additional information:</label>
        <textarea name="description" id="description" cols="30" rows="5"></textarea>
        <button type="submit">Submit</button>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p><strong>{{ $error }}</strong></p>
            @endforeach
        @endif
    </form>
@endsection
