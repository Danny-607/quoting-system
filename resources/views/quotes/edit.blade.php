@extends('layouts.dashboard')

@section('content')
<form action="{{ route('quotes.update', $quote->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="description">Description</label>
    <textarea name="description" required>{{ $quote->description }}</textarea>

    <label for="preliminary_price">Preliminary Price</label>
    <input type="number" name="preliminary_price" value="{{ $quote->preliminary_price }}" required>

    <label for="approved">Approved</label>
    <select name="approved" required>
        <option value="yes" {{ $quote->approved === 'yes' ? 'selected' : '' }}>Yes</option>
        <option value="no" {{ $quote->approved === 'no' ? 'selected' : '' }}>No</option>
    </select>

    <button type="submit">Update Quote</button>
</form>
@endsection
