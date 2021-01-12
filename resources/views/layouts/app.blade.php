<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row min-vh-100 flex-column flex-md-row">
        <aside class="col-12 col-md-2 p-0 flex-shrink-1">
            <nav class="navbar navbar-expand navbar-light flex-md-column flex-row align-items-start py-2">
                <div class="collapse navbar-collapse ">
                    <ul class="flex-md-column flex-row navbar-nav w-100 justify-content-between">
                        <div class="p-2">
                            <div class="dot p-5 align-items-center ">
                                <span>{{ Auth::user()->name[0] }}</span>
                            </div>
                        </div>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        <li class="nav-item pl-2">
                            <a class="nav-link pl-0 " href="{{route('home')}}"><i class="fas fa-coins"></i> <span
                                    class="d-none d-md-inline pl-2">Accounts</span></a>
                        </li>
                        <li class="nav-item pl-2">
                            <a class="nav-link pl-0 " href="{{route('account-create')}}"><i class="fas fa-plus"></i><span
                                    class="d-none d-md-inline pl-2">New Account</span></a>
                        </li>

                        <li class="nav-item pl-2">
                            <a class="nav-link pl-0 " href="{{route('all-transactions')}}"><i class="fas fa-history"></i><span
                                    class="d-none d-md-inline pl-2">All Transactions</span></a>
                        </li>
                        <li class="nav-item pl-2">
                            <a class="nav-link pl-0 " href="{{route('notifications')}}"><i class="fas fa-history"></i><span
                                    class="d-none d-md-inline pl-2">Notifications</span></a>
                        </li>

                    </ul>
                </div>
            </nav>
        </aside>
        <main class="col bg-faded py-3 flex-grow-1">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>

