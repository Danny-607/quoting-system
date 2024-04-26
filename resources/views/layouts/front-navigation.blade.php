<!DOCTYPE html>
<!-- Specifies that the document type is HTML5 -->
<html lang="en">
<!-- Sets the language of the document to English -->

<head>
    <meta charset="UTF-8">
    <!-- Sets the character encoding to UTF-8, which includes most characters from all known languages -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Ensures the page is responsive on different devices by setting the viewport width to match the device -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Tells Internet Explorer to use its latest rendering engine -->

    {{-- Commented out: Bootstrap CDN link for quick design setup --}}
    <!-- vite directive for including a compiled front-end.scss file for styling -->
    @vite(['resources/sass/front-end.scss'])
    <!-- Dynamic title generation based on the specific page content -->
    <title>@yield('title')</title>
</head>

<nav class="navbar">
    <!-- Navigation bar container -->
    <ul class="nav-links left">
        <!-- Left-aligned navigation links -->
        <li><a href="{{ route('quotes.create') }}">Get a Quote</a></li>
        <!-- Link for users to initiate a quote request -->
    </ul>

    <div class="logo">
        <!-- Centered logo -->
        <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo"></a>
        <!-- Logo image pointing to the homepage -->
    </div>

    <ul class="nav-links right">
        <!-- Right-aligned navigation links -->
        @guest
            <!-- Conditional content for unauthenticated users -->
            @if (Route::has('login'))
                <li><a href="{{ route('login') }}">Login</a></li>
                <!-- Login link if the login route is available -->
            @endif
            @if (Route::has('register'))
                <li><a href="{{ route('register') }}">Register</a></li>
                <!-- Registration link if the register route is available -->
            @endif
        @else
            <!-- Content for authenticated users -->
            <li><a href="#" role="button">{{ Auth::user()->first_name }}</a></li>
            <!-- Displays the first name of the logged-in user -->
            <li>
                <!-- Role-based conditional navigation -->
                @if (Auth::user()->hasRole('customer'))
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
                <!-- Logout link that triggers a form submission -->
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        @endguest
    </ul>
</nav>

<body>
    <main>
        <!-- Main content area where different views are rendered based on routes -->
        @yield('content')
    </main>
</body>
</html>
