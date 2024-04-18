@extends('layouts.dashboard')

@section('content')
<form action="{{Route('employees.store')}}" method="POST">
    @csrf
    @method('POST')
    <label for="user_name">Select the user you want to assign to an employee</label>
    <select name="user_name" id="user_name">
        @foreach ($users as $user)
            <option value="{{$user->id}}">{{$user->first_name}}</option>
        @endforeach
    </select>
    <label for="contracted_hours">Weekly contracted hours</label>
    <input type="integer" name="contracted_hours">
    <label for="wage_type">Hourly or salary</label>
    <select name="wage_type" id="wage_type">
        <option value="hourly">Hourly</option>
        <option value="salary">Salary</option>
    </select>
    <label for="wages">Wages</label>
    <input type="decimal" name="wages">

    <button type="submit">Submit</button>
</form>
@endsection