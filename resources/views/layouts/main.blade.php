<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LJS Locadora') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/CSS/styles.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="/js/scripts.js"></script>
</head>

<body>
    <div id="app">
        <header>
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="/img/logo.jpg" alt="LJS Locadora" style="height: 40px;">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a href="/" class="nav-link">Início</a>
                            </li>

                            <li class="nav-item">

                                <div class="dropdown">

                                    <button class="dropbtn"> Cadastro </button>

                                    <div class="dropdown-content">

                                 <!--   <a href="/user/novo"> Usuário </a>  -->
                                        <a href="/clients/create"> Cliente </a>
                                        <a href="/machines/create"> Máquina </a>

                                    </div>

                            </li>

                            <li class="nav-item">

                                <div class="dropdown">

                                    <button class="dropbtn"> Máquina </button>

                                    <div class="dropdown-content">

                                        <a href="/rentals/create"> Locação </a>
                                        <a href="/maintenances/create"> Manutenção </a>
                                        <a href="/depreciations/create"> Depreciação </a>
                                       

                                    </div>

                            </li>

                            <li class="nav-item">

                                <div class="dropdown">

                                    <button class="dropbtn"> Controle </button>

                                    <div class="dropdown-content">

                                        <a href="/dashboard"> Máquinas </a>
                                        <a href="/rentals"> Locações </a>
                                        <a href="/schedule_requests"> Agendamentos </a>
                                   <!-- <a href="/user"> Usuário </a> -->
                                        <a href="/clients"> Clientes </a>
                                        <a href="/maintenances"> Manutenções </a>
                                        <a href="/depreciations"> Depreciações </a>
                                        <a href="/reports"> Relatórios </a>
                                     

                                    </div>

                            </li>


                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            @guest
                            @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @endif

                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                            @endif
                            @else

                            <li class="nav-item">

                                <div class="dropdown">

                                    <button class="dropbtn"> {{ Auth::user()->name }} </button>

                                    <div class="dropdown-content">

                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                 <!-- <a class="dropdown-item" href="/"> {{ __('Profile') }} </a> -->


                                    </div>

                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                    </div>
                    </li>
                    @endguest
                    </ul>
                </div>
    </div>
    </nav>
    </header>

    <main class="py-4">
        <div class="container">
            @if (session('msg'))
            <p class="msg">{{ session('msg') }}</p>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="text-center py-4">
        <p>LJS Locadora &copy; 2024</p>
    </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <!-- Ionicons (icons) -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>