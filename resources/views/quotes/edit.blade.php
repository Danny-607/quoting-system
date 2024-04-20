@extends('layouts.dashboard')

@section('content')
    <form action="{{ route('quotes.update', $quote->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="description">Description</label>
        <textarea name="description" required>{{ $quote->description }}</textarea>

        <label for="preliminary_price">Preliminary Price</label>
        <input type="number" name="preliminary_price" value="{{ $quote->preliminary_price }}" required>

        <label for="status">Approved</label>
        <select name="status" required>
            <option value="approved" {{ $quote->status === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="unapproved" {{ $quote->status === 'unapproved' ? 'selected' : '' }}>Unapproved</option>
        </select>

        <button type="submit">Update Quote</button>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p><strong>{{ $error }}</strong></p>
            @endforeach
        @endif
    </form>
@endsection
