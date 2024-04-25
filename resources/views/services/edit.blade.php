@extends('layouts.dashboard')
@section('title', 'Edit a service')
@section('content')
    @can('manage services')


        <div class="form-container">
            <div class="card">
                <form action="{{ route('services.update', ['service' => $service->id]) }}" method="post">
                    @csrf
                    @method('put')
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="service_name" value="{{ old('name', $service->name) }}">

                    <label for="cost">Cost:</label>
                    <input type="number" name="cost" id="service_cost" step="0.01"
                        value="{{ old('cost', $service->cost) }}">

                    <label for="price">Price:</label>
                    <input type="number" name="price" id="service_price" step="0.01"
                        value="{{ old('price', $service->price) }}">

                    <label for="category_id">Category:</label>
                    <select name="category_id" id="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $service->service_category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn save-btn" type="submit">Update Service</button>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p><strong>{{ $error }}</strong></p>
                        @endforeach
                    @endif
                </form>
            </div>
            <div>
            @endcan
        @endsection
