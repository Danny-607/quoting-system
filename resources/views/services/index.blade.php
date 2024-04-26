{{-- Extends the dashboard layout to ensure consistency across the admin interface --}}
@extends('layouts.dashboard')

{{-- Sets the title of the page in the dashboard to "Services overview" --}}
@section('title', 'Services overview')

{{-- Begins the content section for the page --}}
@section('content')

    {{-- Permission check to ensure only users with the capability to manage services can access this page --}}
    @can('manage services')

    {{-- Main heading for the page --}}
    <h1>Services</h1>

    {{-- Table to display details of each service --}}
    <table>
        {{-- Table header defining the data columns --}}
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Cost</th>
            <th>Price</th>
            <th>Profit</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>

        {{-- Loop through each service and display its information in a table row --}}
        @foreach ($services as $service)
        <tr>
            <td>{{$service->id}}</td>
            <td>{{$service->name}}</td>
            <td>{{$service->cost}}</td>
            <td>{{$service->price}}</td>
            <td>{{$service->profit}}</td>
            {{-- Check if the service has a category and display it, otherwise display 'No Category' --}}
            <td>{{$service->serviceCategory ? $service->serviceCategory->name : 'No Category'}}</td>

            {{-- Action buttons for editing and deleting the service --}}
            <td>
                <div class="action-buttons">
                    <a class="edit-btn btn" href="{{route('services.edit', ['service' => $service->id])}} ">Edit</a>
                    <form method="post" action="{{route('services.destroy', ['service' => $service->id])}}" >
                        @csrf
                        @method('delete')
                        <input type="submit" class="delete-btn btn" name="delete" value="Delete">
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </table>

    {{-- Display a success message if it exists in the session --}}
    <p>@if (session()->has('success'))
        {{ session('success') }}
    @endif</p>

    {{-- Buttons to create a new service or category --}}
    <div class="btn-group">
        <a id="create-role-btn" class="create-btn btn" href="{{ route('categories.create') }}">Create a new category</a>
        <a class="create-btn btn " href="{{route('services.create')}}">Create a service</a>
    </div>

    {{-- Ends the permission check --}}
    @endcan

{{-- Ends the content section --}}
@endsection
