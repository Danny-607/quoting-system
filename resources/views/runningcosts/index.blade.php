{{-- Extends a master layout from the layouts.dashboard file --}}
@extends('layouts.dashboard')

{{-- Sets the title section for the page with the content 'Running costs overview' --}}
@section('title', 'Running costs overview')

{{-- Begins the content section for the webpage --}}
@section('content')

{{-- Blade directive to check if the authenticated user has permission to manage running costs --}}
@can('manage running costs')
    
    {{-- HTML header tag displaying the title of the section --}}
    <h1>Operational Costs</h1>

    {{-- HTML table structure for displaying running costs --}}
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
            {{-- Loop through each running cost passed to the view and create a table row for each --}}
            @foreach ($runningCosts as $runningCost)
                <tr>
                    <td>{{ $runningCost->name }}</td>
                    <td>£{{ $runningCost->cost }}</td>
                    <td>{{ $runningCost->date_incurred }}</td>
                    <td>{{ $runningCost->runningCostCategory->name ?? 'No Category' }}</td>
                    <td>{{ $runningCost->repeating ? 'Yes' : 'No' }}</td>
                    <td>
                        <div class="action-buttons">
                            {{-- Form for editing the running cost --}}
                            <form method="POST" action="{{ route('runningcosts.edit', $runningCost->id) }}">
                                @csrf {{-- Blade directive to include CSRF token --}}
                                @method('put') {{-- Specify the HTTP method to be 'put' --}}
                                <button class="edit-btn btn" type="submit">Edit</button>
                            </form>
                            {{-- Form for deleting the running cost --}}
                            <form method="POST" action="{{ route('runningcosts.destroy', $runningCost->id) }}">
                                @csrf {{-- Include CSRF token for security --}}
                                @method('DELETE') {{-- Specify the HTTP method to be 'DELETE' --}}
                                <button class="delete-btn btn" type="submit">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Button group for creating new categories or adding new expenses --}}
    <div class="btn-group">
        <a id="create-role-btn" class="create-btn btn" href="{{ route('categories.create') }}">Create a new category</a>
        <a class="create-btn btn" href="{{route('runningcosts.create')}}">Add an expense</a>
    </div>

@endcan {{-- Ends the permission check for managing running costs --}}

{{-- Ends the content section --}}
@endsection
