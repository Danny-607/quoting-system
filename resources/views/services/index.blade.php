@extends('layouts.dashboard')

@section('content')
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
    </tr>
</table>
@foreach ($services as $service)

@endforeach
@endsection