<!DOCTYPE html>
<!-- Declaration for HTML5 to ensure the browser uses the latest rendering mode -->
<html lang="en">
<!-- The language attribute set to English for accessibility and SEO -->

<head>
    <meta charset="UTF-8">
    <!-- Character set declaration to ensure text is rendered correctly -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Viewport settings to ensure the site is mobile-responsive -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Ensures IE compatibility mode is set to the latest rendering engine available -->
    <script src="https://kit.fontawesome.com/a3326e38a6.js" crossorigin="anonymous"></script>
    <!-- Font Awesome for icons, loaded from a CDN with anonymous crossorigin to provide CORS header -->
    @vite(['resources/sass/back-end.scss'])
    <!-- Vite.js is used here for bundling the SASS file which styles the backend -->
    <title>@yield('title')</title>
    <!-- The title tag is dynamically set based on the content yielded by 'title' in different views -->
</head>

<body>
    <nav class="sidebar">
        <!-- Navigation sidebar for the application's dashboard -->
        <ul>
            <!-- User account display, showing the user's name in uppercase -->
            <li class="account">{{ strtoupper($name) }}</li>
            
            <!-- Conditional rendering of dashboard links based on user roles -->
            @if (auth()->user()->hasRole('admin'))
                <li><a href="{{ route('admin.index') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            @elseif (auth()->user()->hasRole('manager'))
                <li><a href="{{ route('manager.index') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            @elseif (auth()->user()->hasRole('designer'))
                <li><a href="{{ route('designer.index') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            @endif

            <!-- Common navigation links for all users -->
            <li><a href="{{ route('services.index') }}"><i class="fas fa-concierge-bell"></i> Services</a></li>
            <li><a href="{{ route('quotes.index') }}"><i class="fas fa-file-invoice-dollar"></i> Quotes</a></li>
            <li><a href="{{ route('employees.index') }}"><i class="fas fa-users"></i> Employees</a></li>
            <li><a href="{{ route('projects.index') }}"><i class="fas fa-project-diagram"></i> Projects</a></li>
            <li><a href="{{ route('runningcosts.index') }}"><i class="fas fa-calculator"></i> Operational Costs</a></li>

            <!-- Logout functionality through a POST form to ensure security -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-btn" type="submit"> Logout</button>
                </form>
            </li>
        </ul>
    </nav>

    <main>
        <!-- Main content area where different views are rendered based on routes -->
        @yield('content')
    </main>
</body>

</html>
