@extends('layouts.app')

@section('content')

<form action="{{route('services.store')}}" method="post">
    @csrf
    @method('post')
    <label for="name">Enter the name of the service</label>
    <input type="text" name="name" id="service_name">
    <label for="price">Enter the price of the service</label>
    <input type="text" name="price" id="service_name">

    <button type="submit" value="save">Save a new service</button>
</form>

@if($errors->any())
@foreach ($errors->all() as $error)
    <p>{{$error}}</p>
@endforeach
    
@endif
@endsection