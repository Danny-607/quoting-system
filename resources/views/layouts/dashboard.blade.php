<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite(['resources/sass/back-end.scss'])
    <title>@yield('title')</title>
</head>

<body>
    <nav class="sidebar">
        <ul>
            <li class="account">{{ strtoupper($name) }}</li>
            @if (auth()->user()->hasRole('admin'))
                <li><a href="{{ route('admin.index') }}">Dashboard</a></li>
            @elseif (auth()->user()->hasRole('manager'))
                <li><a href="{{ route('manager.index') }}">Dashboard</a></li>
            @elseif (auth()->user()->hasRole('designer'))
                <li><a href="{{ route('designer.index') }}">Dashboard</a></li>
            @endif
            <li><a href="{{ route('services.index') }}">Services</a></li>
            <li><a href="{{ route('quotes.index') }}">Quotes</a></li>
            <li><a href="{{ route('employees.index') }}">Employees</a></li>
            <li><a href="{{ route('projects.index') }}">Projects</a></li>
            <li><a href="{{ route('runningcosts.index') }}">Running Costs</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-btn" type="submit">Logout</button>
                </form>
            </li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>
</body>

</html>
