<head>
    @vite(['resources/sass/front-end.scss'])
</head>
<nav class="navbar">
    <ul class="nav-links left">
        <li><a href="{{ route('about') }}">About Us</a></li>
        <li><a href="{{ route('works') }}">Previous Works</a></li>
        <li><a href="{{ route('quotes.create') }}">Get a Quote</a></li>
    </ul>
    
    <div class="logo">
        <a href="{{ url('/') }}"><img src="{{asset('images/logo.png')}}" alt="Logo"></a>
    </div>

    <ul class="nav-links right">
        @guest
            @if (Route::has('login'))
            <li><a href="{{ route('login') }}">Login</a></li>
            @endif
            @if (Route::has('register'))
            <li><a href="{{ route('register') }}">Register</a></li>
            @endif
        @else
            <li><a href="#" role="button">{{ Auth::user()->first_name }}</a></li>
            <li>
                @if(Auth::user()->hasRole('customer'))
                <a href="{{ route('customer.index') }}">Dashboard</a>
            @elseif(Auth::user()->hasRole('admin'))
                <a href="{{ route('admin.index') }}">Dashboard</a>
                @elseif(Auth::user()->hasRole('manager'))
                <a href="{{ route('manager.index') }}">Dashboard</a>
            @elseif(Auth::user()->hasRole('designer'))
                <a href="{{ route('designer.index') }}">Dashboard</a>
            @endif
            </li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        @endguest
    </ul>
</nav>
<main>
    @yield('content')
</main>
