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
        <th>Actions</th>
    </tr>
    @foreach ($services as $service)
    <tr>
        <td>{{$service->id}}</td>
        <td>{{$service->name}}</td>
        <td>{{$service->cost}}</td>
        <td>{{$service->price}}</td>
        <td>{{$service->profit}}</td>
        <td>{{$service->serviceCategory ? $service->serviceCategory->name : 'No Category'}}</td> 
        
            <td>
                <div class="action-buttons">
                    <a class="edit-btn btn" href="{{route('services.edit', ['service' => $service->id])}} ">Edit</a>
                <form method="post" action="{{route('services.destroy', ['service' => $service->id])}}" >
                    @csrf
                    @method('delete')
                    <input type="submit" class="delete-btn btn" value="Delete">
                </form>
            </div>
        </td>
        
    </tr>
    @endforeach
</table>
<p>@if (session()->has('success'))
    {{ session('success') }}
@endif</p>
<a class="create-btn btn " href="{{route('services.create')}}">Create a service</a>
@endsection
