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
                <td>{{ $runningCost->runningCostCategory->name ?? 'No Category' }}</td>

                <td>{{ $runningCost->repeating ? 'Yes' : 'No' }}</td>
                <td>
                    <div class="action-buttons">
                    <form method="POST" action="{{ route('runningcosts.edit', $runningCost->id) }}">
                        @csrf
                        @method('put')
                        <button class="edit-btn btn" type="submit">Edit</button>
                    </form>
                    <form method="POST" action="{{ route('runningcosts.destroy', $runningCost->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="delete-btn btn" type="submit">Delete</button>
                    </form>
                </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<a class="create-btn btn" href="{{route('runningcosts.create')}}">Add an expense</a>
@endsection