@extends('layouts.dashboard')

@section('content')
<form action="{{route('services.update',['service' => $service])}}" method="post">
    @csrf
    @method('put')
    <label for="name">Name</label>
    <input type="text" name="name" id="service_name" value="{{$service->name}}">
    <label for="price">Price</label>
    <input type="text" name="price" id="service_name" value="{{$service->price}}">

    <button type="submit" value="save">Update service</button>
</form>

@if($errors->any())
@foreach ($errors->all() as $error)
    <p>{{$error}}</p>
@endforeach
@endif
@endsection