{{-- Extends the dashboard layout to maintain consistent styling and functionality across the admin interface --}}
@extends('layouts.dashboard')

{{-- Sets the page title in the dashboard to "Quotes overview" --}}
@section('title', 'Quotes overview')

{{-- Starts defining the content section of the page --}}
@section('content')

    {{-- Checks if the authenticated user has permission to manage quotes --}}
    @can('manage quotes')

        {{-- Main heading for the page, indicating it is focused on managing quotes --}}
        <h1>Quotes</h1>

        {{-- Table to display an overview of quotes --}}
        <table>
            {{-- Table header defining the data columns --}}
            <thead>
                <tr>
                    <th>Quote ID</th>
                    <th>Client Name</th>
                    <th>Description</th>
                    <th>Services</th>
                    <th>Quoted Price</th>
                    <th>Accept or Deny</th>
                </tr>
            </thead>
            {{-- Table body where each quote is listed --}}
            <tbody>
                {{-- Loop through each quote and create a table row for each one --}}
                @foreach ($quotes as $quote)
                    {{-- Only display unapproved quotes --}}
                    @if($quote->status == "unapproved")
                        <tr>
                            {{-- Display the unique identifier for each quote --}}
                            <td>{{ $quote->id }}</td>
                            
                            {{-- Display the client's name associated with each quote --}}
                            <td>{{ $quote->user->first_name }} {{$quote->user->last_name}}</td>

                            {{-- Use a Livewire component to show a more detailed description, allowing interactive content loading --}}
                            <td>
                                @livewire('show-more-description', ['quote' => $quote])
                            </td>

                            {{-- Use another Livewire component to display services included in the quote --}}
                            <td>
                                @livewire('show-more-services', ['quote' => $quote])
                            </td>

                            {{-- Display the preliminary price of the quote --}}
                            <td>
                                £{{ $quote->preliminary_price }}
                            </td>

                            {{-- Provide action buttons to accept, deny, or edit the quote --}}
                            <td>
                                <div class="action-buttons">
                                    {{-- Form to accept the quote --}}
                                    <form method="POST" action="{{ route('quotes.accept', $quote->id) }}">
                                        @csrf
                                        @method('put')
                                        <button class="save-btn btn" type="submit">Accept</button>
                                    </form>
                                    {{-- Form to deny (delete) the quote --}}
                                    <form method="POST" action="{{ route('quotes.destroy', $quote->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="delete-btn btn" type="submit">Deny</button>
                                    </form>
                                    {{-- Link to edit the quote --}}
                                    <a class="edit-btn btn" href="{{Route('quotes.edit', $quote->id)}}">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        {{-- Link to create a new quote --}}
        <a class="create-btn btn" href="{{Route('quotes.create')}}">Create a new quote</a>

    {{-- Ends the permission check --}}
    @endcan

{{-- Ends the content section of the blade template --}}
@endsection
