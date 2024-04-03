<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite(['resources/sass/style.scss'])
    <title>Document</title>
</head>
<body>
    <nav class="sidebar">
        <ul>
            <li class="account">{{$username}}</li>
            <li><a href="{{Route('services.index')}}">Services</a></li>
            <li><a href="{{Route('quotes.index')}}">Quotes</a></li>
            <li>yes</li>
            <li>yes</li>
            <li>yes</li>
            <li>yes</li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>