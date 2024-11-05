<!DOCTYPE html>
<html>
<head>
    <title>Chat App</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav>
        <ul>
            @if (Auth::check())
                <li>{{ Auth::user()->name }}</li>
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
            @endif
        </ul>
    </nav>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>
