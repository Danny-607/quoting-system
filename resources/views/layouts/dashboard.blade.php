<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/a3326e38a6.js" crossorigin="anonymous"></script>
    @vite(['resources/sass/back-end.scss'])
    <title>@yield('title')</title>
</head>

<body>
    <nav class="sidebar">
        <ul>
            <li class="account">{{ strtoupper($name) }}</li>
            @if (auth()->user()->hasRole('admin'))
                <li><a href="{{ route('admin.index') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            @elseif (auth()->user()->hasRole('manager'))
                <li><a href="{{ route('manager.index') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            @elseif (auth()->user()->hasRole('designer'))
                <li><a href="{{ route('designer.index') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            @endif
            <li><a href="{{ route('services.index') }}"><i class="fas fa-concierge-bell"></i> Services</a></li>
            <li><a href="{{ route('quotes.index') }}"><i class="fas fa-file-invoice-dollar"></i> Quotes</a></li>
            <li><a href="{{ route('employees.index') }}"><i class="fas fa-users"></i> Employees</a></li>
            <li><a href="{{ route('projects.index') }}"><i class="fas fa-project-diagram"></i> Projects</a></li>
            <li><a href="{{ route('runningcosts.index') }}"><i class="fas fa-calculator"></i> Operational Costs</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-btn" type="submit"> Logout</button>
                </form>
            </li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>
</body>

</html>
