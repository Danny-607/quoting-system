@extends('layouts.dashboard')
@section('title', 'Create a running cost')
@section('content')
@can ('manage running costs')
    

    <div class="form-container">
        <div class="card">
            <h2>Add Running Cost</h2>
            <form action="{{ Route('runningcosts.store') }}" method="POST">
                @csrf
                @method('POST')
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="cost">Cost:</label>
                <input type="number" id="cost" name="cost" step="0.01" required>

                <label for="date_incurred">Date Incurred:</label>
                <input type="date" id="date_incurred" name="date_incurred" required>

                <label for="category">category</label>
                <select name="category" id="category">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <div class="checkbox-container">
                    <label for="repeating">Repeating:</label>
                    <input type="checkbox" id="repeating" name="repeating" value="1">
                </div>


                <button class="btn save-btn" type="submit">Submit</button>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p><strong>{{ $error }}</strong></p>
                    @endforeach
                @endif
            </form>
        </div>
    </div>
    @endcan
@endsection
