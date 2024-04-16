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
        <ul></ul>
        <li> 
            <a id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ Auth::user()->name }}</a>
        </li>
        <li>
            <a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }}</a>

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