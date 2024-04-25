@extends('layouts.dashboard')

@section('content')
<div class="form-container">
    <div class="card">
    <h1>Create Category</h1>
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

            <label for="name">Category Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="type">Category Type:</label>
            <select id="type" name="type">
                <option value="service">Service</option>
                <option value="running_cost">Running Costs</option>
            </select>

        <button type="submit" class="btn save-btn">Create Category</button>
    </form>
</div>
</div>
@endsection
