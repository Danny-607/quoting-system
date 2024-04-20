@extends('layouts.dashboard')

@section('content')
    <div class="form-container">
        <div class="card">
            <h2>Create a new service</h2>
            <form action="{{ route('services.store') }}" method="post">
                @csrf
                <label for="name">Enter the name of the service:</label>
                <input type="text" name="name" id="service_name">

                <label for="cost">Enter the cost of the service:</label>
                <input type="number" name="cost" id="service_cost" step="0.01">

                <label for="price">Enter the price of the service:</label>
                <input type="number" name="price" id="service_price" step="0.01">

                <label for="category_id">Select the category of the service:</label>
                <select name="category_id" id="service_category">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <button class="btn save-btn" type="submit">Save a new service</button>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p><strong>{{ $error }}</strong></p>
                    @endforeach
                @endif
            </form>

        </div>
    </div>


@endsection
