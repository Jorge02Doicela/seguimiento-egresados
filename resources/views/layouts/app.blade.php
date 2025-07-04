<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Gestión de Egresados ISUS')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    </head>
<body class="font-open-sans antialiased bg-gray-light text-text-main">

    @auth
        @if(auth()->user()->hasRole('graduate'))
            @php
                $unreadSurveyCount = auth()->user()->notifications()
                    ->whereNull('read_at')
                    ->where('type', 'App\Notifications\NewSurveyNotification')
                    ->count();
            @endphp

            @if($unreadSurveyCount > 0)
                <div class="bg-yellow-accent text-white p-3 text-center text-sm font-semibold sticky top-0 z-50 shadow-md">
                    Tienes <span class="font-bold">{{ $unreadSurveyCount }}</span> notificación(es) nueva(s).
                    <a href="{{ route('notifications.index') }}" class="underline hover:text-primary-dark ml-2">Ver notificaciones</a>
                </div>
            @endif
        @endif
    @endauth

    <nav class="bg-primary text-white shadow-lg">
        <div class="container mx-auto px-4 py-4 flex flex-wrap items-center justify-between">
            <a class="text-2xl font-bold font-headings tracking-tight" href="/">ISUS</a>

            <button class="lg:hidden text-white focus:outline-none" type="button" id="navbar-toggle">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>

            <div class="hidden w-full lg:flex lg:w-auto lg:items-center" id="navbarSupportedContent">
                @auth
                    <ul class="flex flex-col lg:flex-row lg:space-x-8 mt-4 lg:mt-0 w-full lg:w-auto">
                        <li class="mb-2 lg:mb-0"><a class="block py-2 px-3 rounded hover:bg-primary-dark transition-colors duration-200" href="{{ route('dashboard') }}">Home</a></li>

                        @role('admin')
                            <li class="mb-2 lg:mb-0"><a class="block py-2 px-3 rounded hover:bg-primary-dark transition-colors duration-200" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                            <li class="mb-2 lg:mb-0"><a class="block py-2 px-3 rounded hover:bg-primary-dark transition-colors duration-200" href="{{ route('admin.surveys.index') }}">Encuestas</a></li>
                        @endrole

                        @role('graduate')
                            <li class="mb-2 lg:mb-0"><a class="block py-2 px-3 rounded hover:bg-primary-dark transition-colors duration-200" href="{{ route('graduate.home') }}">Egresado</a></li>
                            <li class="mb-2 lg:mb-0"><a class="block py-2 px-3 rounded hover:bg-primary-dark transition-colors duration-200" href="{{ route('graduate.surveys.index') }}">Responder Encuestas</a></li>
                        @endrole

                        @role('employer')
                            <li class="mb-2 lg:mb-0"><a class="block py-2 px-3 rounded hover:bg-primary-dark transition-colors duration-200" href="{{ route('employer.home') }}">Empleador</a></li>
                            <li class="mb-2 lg:mb-0"><a class="block py-2 px-3 rounded hover:bg-primary-dark transition-colors duration-200" href="{{ route('employer.graduates') }}">Buscar Egresados</a></li>
                        @endrole
                    </ul>

                    <ul class="flex flex-col lg:flex-row lg:space-x-8 mt-4 lg:mt-0 lg:ml-auto">
                        <li class="mb-2 lg:mb-0">
                            @if(auth()->user()->hasRole('graduate'))
                                <a class="block py-2 px-3 rounded hover:bg-primary-dark transition-colors duration-200" href="{{ route('graduate.profile.edit') }}">Perfil</a>
                            @elseif(auth()->user()->hasRole('admin'))
                            @elseif(auth()->user()->hasRole('employer'))
                                <a class="block py-2 px-3 rounded hover:bg-primary-dark transition-colors duration-200" href="#">Perfil empleador</a> {{-- Aquí podrías poner su ruta personalizada si existe --}}
                            @endif
                        </li>
                        <li class="mb-2 lg:mb-0">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left py-2 px-3 rounded hover:bg-primary-dark transition-colors duration-200 focus:outline-none">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                @else
                    <ul class="flex flex-col lg:flex-row lg:space-x-8 mt-4 lg:mt-0 lg:ml-auto">
                        <li class="mb-2 lg:mb-0"><a class="block py-2 px-3 rounded hover:bg-primary-dark transition-colors duration-200" href="{{ route('login') }}">Ingresar</a></li>
                        <li class="mb-2 lg:mb-0"><a class="block py-2 px-3 rounded hover:bg-primary-dark transition-colors duration-200" href="{{ route('register') }}">Registrarse</a></li>
                    </ul>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 mt-8 mb-12">
        @yield('content')
    </main>

    <footer class="bg-gray-corporate text-white py-8 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Instituto Superior Universitario Tecnológico Sucre. Todos los derechos reservados.</p>
            <p class="text-sm mt-2">"Tu camino hacia el éxito académico y educación profesional"</p>
        </div>
    </footer>

    <script>
        // JavaScript para el toggle del menú en dispositivos móviles
        document.getElementById('navbar-toggle').addEventListener('click', function() {
            const navContent = document.getElementById('navbarSupportedContent');
            navContent.classList.toggle('hidden');
        });
    </script>

    @yield('scripts') {{-- Aquí se incluyen scripts adicionales específicos de cada vista --}}
</body>
</html>
