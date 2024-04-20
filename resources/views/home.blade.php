@extends('layouts.front-navigation')
@section('title', 'Home')
@section('content')
<div class="centered-content">
    <h2>AFFORDABLE WEB DESIGN</h2>
    <p>Crafting Digital Experiences, One Pixel at a Time.</p>
    <div class="button-group">
        <button><a href="{{ route('quotes.create') }}">Get a quote</a></button>
    </div>
</div>
@endsection
