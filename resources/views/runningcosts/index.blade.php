@extends('layouts.dashboard')

@section('content')
<table>
    <thead>
        <tr>
            
            <th>Expense</th>
            <th>Cost</th>
            <th>Date Incurred</th>
            <th>Category</th>
            <th>Repeating</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($runningCosts as $runningCost)
            <tr>
                <td>{{ $runningCost->name }}</td>
                <td>£{{ $runningCost->cost }}</td>
                <td>{{ $runningCost->date_incurred }}</td>
                <td>{{$runningCost->category->name}}</td>
                <td>{{ $runningCost->repeating ? 'Yes' : 'No' }}</td>
                <td>
                    <form method="POST" action="{{ route('runningcosts.edit', $runningCost->id) }}">
                        @csrf
                        @method('put')
                        <button type="submit">Edit</button>
                    </form>
                    <form method="POST" action="{{ route('runningcosts.destroy', $runningCost->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<button><a href="{{route('runningcosts.create')}}">Add an expense</a></button>
@endsection