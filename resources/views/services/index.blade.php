@extends('layouts.dashboard')

@section('content')
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Cost</th>
        <th>Price</th>
        <th>Profit</th>
        <th>Category</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    @foreach ($services as $service)
    <tr>
        <td>{{$service->id}}</td>
        <td>{{$service->name}}</td>
        <td>{{$service->cost}}</td>
        <td>{{$service->price}}</td>
        <td>{{$service->profit}}</td>
        <td>{{$service->serviceCategory ? $service->serviceCategory->name : 'No Category'}}</td> 
        <td><a href="{{route('services.edit', ['service' => $service->id])}}">Edit</a></td>
        <td>
            <form method="post" action="{{route('services.destroy', ['service' => $service->id])}}" >
                @csrf
                @method('delete')
                <input type="submit" value="Delete">
            </form>
        </td>
    </tr>
    @endforeach
</table>
<p>@if (session()->has('success'))
    {{ session('success') }}
@endif</p>
<a href="{{route('services.create')}}">Create a service</a>
@endsection
