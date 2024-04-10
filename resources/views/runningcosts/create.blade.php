@extends('layouts.dashboard')

@section('content')
<h1>Add Running Cost</h1>
<form action="{{Route('runningcosts.store')}}" method="POST">
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
            <option value="{{$category->id}}">{{$category->name}}</option>
        @endforeach
    </select>
    
    <label for="repeating">Repeating:</label>
    <input type="checkbox" id="repeating" name="repeating" value="1">


    
    <input type="submit" value="Submit">
</form>

@endsection