    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>@yield('title', 'Gestión de Egresados ISUS')</title>

        {{-- Import Vite styles and scripts (includes your Tailwind CSS) --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Bootstrap Icons for consistent iconography --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    </head>
    <body class="font-body antialiased bg-bg-primary text-text-primary min-h-screen flex flex-col">

        @auth
            @if(auth()->user()->hasRole('graduate'))
                @php
                    $unreadSurveyCount = auth()->user()->notifications()
                        ->whereNull('read_at')
                        ->where('type', 'App\Notifications\NewSurveyNotification')
                        ->count();
                @endphp

                @if($unreadSurveyCount > 0)
                    {{-- Notification bar for unread surveys --}}
                    <div class="bg-warning text-text-inverse p-3 text-center text-sm font-semibold sticky top-0 z-sticky shadow-md">
                        Tienes <span class="font-bold">{{ $unreadSurveyCount }}</span> notificación(es) nueva(s).
                        <a href="{{ route('notifications.index') }}" class="underline hover:text-primary-dark ml-2">Ver notificaciones</a>
                    </div>
                @endif
            @endif
        @endauth

        {{-- Main Navigation Bar --}}
        <nav class="bg-primary text-text-inverse shadow-lg">
            <div class="container mx-auto px-4 py-4 flex flex-wrap items-center justify-between">
                {{-- Brand Logo --}}
                <a class="text-2xl font-headings font-bold tracking-tight" href="/">ISUS</a>

                {{-- Mobile navigation toggle button --}}
                <button class="lg:hidden text-text-inverse focus:outline-none" type="button" id="navbar-toggle">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                {{-- Navigation links (desktop and toggled mobile) --}}
                <div class="hidden w-full lg:flex lg:w-auto lg:items-center z-dropdown" id="navbarSupportedContent">
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

                        {{-- User-specific links and logout --}}
                        <ul class="flex flex-col lg:flex-row lg:space-x-8 mt-4 lg:mt-0 lg:ml-auto">
                            <li class="mb-2 lg:mb-0">
                                @if(auth()->user()->hasRole('graduate'))
                                    <a class="block py-2 px-3 rounded hover:bg-primary-dark transition-colors duration-200" href="{{ route('graduate.profile.edit') }}">Perfil</a>
                                @elseif(auth()->user()->hasRole('admin'))
                                    {{-- Admin profile link can be added here if needed --}}
                                @elseif(auth()->user()->hasRole('employer'))
                                    <a class="block py-2 px-3 rounded hover:bg-primary-dark transition-colors duration-200" href="#">Perfil empleador</a> {{-- Placeholder for employer profile link --}}
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
                        {{-- Guest navigation links --}}
                        <ul class="flex flex-col lg:flex-row lg:space-x-8 mt-4 lg:mt-0 lg:ml-auto">
                            <li class="mb-2 lg:mb-0"><a class="block py-2 px-3 rounded hover:bg-primary-dark transition-colors duration-200" href="{{ route('login') }}">Ingresar</a></li>
                            <li class="mb-2 lg:mb-0"><a class="block py-2 px-3 rounded hover:bg-primary-dark transition-colors duration-200" href="{{ route('register') }}">Registrarse</a></li>
                        </ul>
                    @endauth
                </div>
            </div>
        </nav>

        {{-- Main content area --}}
        <main class="container mx-auto px-4 mt-8 mb-12 flex-grow">
            @yield('content')
        </main>

        {{-- Footer section --}}
        <footer class="bg-gray-carbon text-text-inverse py-8 mt-auto">
            <div class="container mx-auto px-4 text-center">
                <p>&copy; {{ date('Y') }} Instituto Superior Universitario Tecnológico Sucre.</p>
                <p class="text-sm mt-2">"Tu camino hacia el éxito académico y educación profesional"</p>
            </div>
        </footer>

        {{-- JavaScript for mobile navigation toggle --}}
        <script>
            document.getElementById('navbar-toggle').addEventListener('click', function() {
                const navContent = document.getElementById('navbarSupportedContent');
                navContent.classList.toggle('hidden');
            });
        </script>

        @yield('scripts') {{-- Include additional view-specific scripts --}}
    </body>
    </html>
