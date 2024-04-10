@extends('layouts.dashboard')

@section('content')
    <form action="{{ route('runningcosts.update', ['runningcost' => $runningCost->id]) }}" method="post">
        @csrf
        @method('put')
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ $runningCost->name }}">
        
        <label for="cost">Cost</label>
        <input type="number" name="cost" id="cost" step="0.01" value="{{ $runningCost->cost }}">
        
        <label for="date_incurred">Date Incurred</label>
        <input type="date" name="date_incurred" id="date_incurred" value="{{ $runningCost->date_incurred }}">
        
        <label for="category">Category</label>
        <select name="category" id="category">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $runningCost->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        
        <label for="repeating">Repeating</label>
        <input type="checkbox" name="repeating" id="repeating" value="1" {{ $runningCost->repeating ? 'checked' : '' }}>
        
        <button type="submit">Update Running Cost</button>
    </form>

    @if($errors->any())
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif
@endsection