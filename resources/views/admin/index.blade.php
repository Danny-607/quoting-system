@extends('layouts.dashboard')

@section('content')
<form action="{{ route('admin.role') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="user">Select User:</label>
        <select name="user_id" id="user">
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    <label for="role">Select Role:</label>
    <select name="role" id="role">
        @foreach ($roles as $role)
            <option value="{{ $role->name }}">{{ $role->name }}</option>
        @endforeach
    </select>
    <button type="submit">Submit</button>
</form>


@endsection