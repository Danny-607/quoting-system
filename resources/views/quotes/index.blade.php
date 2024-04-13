@extends('layouts.dashboard')

@section('content')

<table>
    <thead>
        <tr>
            <th>Quote ID</th>
            <th>User Name</th>
            <th>Description</th>
            
            <th>Services</th>
            <th>Quoted Price</th>
            <th>Accept or Deny</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($quotes as $quote)
            <tr>
                <td>{{ $quote->id }}</td>
                
                <td>{{ $quote->user->name }}</td>
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
                    <form method="POST" action="{{ route('quotes.accept', $quote->id) }}">
                        @csrf
                        @method('put')
                        <button type="submit">Accept</button>
                    </form>
                    <form method="POST" action="{{ route('quotes.destroy', $quote->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Deny</button>
                    </form>
                </td>
            </tr>
            
        @endforeach
    </tbody>
</table>
<button><a href="{{Route('quotes.create')}}">Create a new quote</a></button>
@endsection