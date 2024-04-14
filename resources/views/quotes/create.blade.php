@extends('layouts.dashboard')

@section('content')
<form action="{{Route('quotes.store')}}" method="POST">
    @csrf
    @method('POST')
    @livewire('add-service')
    <label for="description">Additional information:</label>
    <textarea name="description" id="description" cols="30" rows="5"></textarea>
    <button type="submit">Submit</button>
</form>

@endsection
