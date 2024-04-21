@extends('layouts.dashboard')
@section('title', 'Quotes overview')
@section('content')
@can('manage quotes')
<table>
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
    <tbody>
        @foreach ($quotes as $quote)
        @if($quote->status == "unapproved")
            <tr>
                <td>{{ $quote->id }}</td>
                
                <td>{{ $quote->user->first_name }} {{$quote->user->last_name}}</td>
                <td>
                    @livewire('show-more-description', ['quote' => $quote])
                </td>
                <td>
                    @livewire('show-more-services', ['quote' => $quote])
                </td>
                <td>
                    £{{ $quote->preliminary_price }}
                </td>
                <td>
                    <div class="action-buttons">
                    <form method="POST" action="{{ route('quotes.accept', $quote->id) }}">
                        @csrf
                        @method('put')
                        <button class="save-btn btn" type="submit">Accept</button>
                    </form>
                    <form method="POST" action="{{ route('quotes.destroy', $quote->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="delete-btn btn" type="submit">Deny</button>
                    </form>
                    <a class="edit-btn btn" href="{{Route('quotes.edit', $quote->id)}}">Edit</a>
                    </div>
                </td>
            </tr>
            @endif
        @endforeach
    </tbody>
</table>
<a class="create-btn btn" href="{{Route('quotes.create')}}">Create a new quote</a>
@endcan
@endsection