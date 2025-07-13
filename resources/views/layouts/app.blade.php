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

    {{-- Barra de notificación si hay encuestas nuevas --}}
    @auth
        @if (auth()->user()->hasRole('graduate'))
            @php
                $unreadSurveyCount = auth()
                    ->user()
                    ->notifications()
                    ->whereNull('read_at')
                    ->where('type', 'App\Notifications\NewSurveyNotification')
                    ->count();
            @endphp

            @if ($unreadSurveyCount > 0)
                <div
                    class="bg-warning text-text-inverse p-3 text-center text-sm font-semibold sticky top-0 z-sticky shadow-md">
                    Tienes <span class="font-bold">{{ $unreadSurveyCount }}</span> notificación(es) nueva(s).
                    <a href="{{ route('notifications.index') }}" class="underline hover:text-primary-dark ml-2">Ver
                        notificaciones</a>
                </div>
            @endif
        @endif
    @endauth

    {{-- Main Navigation Bar --}}
    <nav class="bg-primary text-text-inverse shadow-lg">
        <div class="container mx-auto px-4 py-4 flex flex-wrap items-center justify-between">
            {{-- Brand Logo --}}
            <a class="text-2xl font-headings font-bold tracking-tight text-text-inverse" href="/">ISUS</a>

            {{-- Mobile navigation toggle button --}}
            <button class="lg:hidden text-text-inverse focus:outline-none" type="button" id="navbar-toggle">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            {{-- Navigation links --}}
            <div class="hidden w-full lg:flex lg:w-auto lg:items-center z-dropdown" id="navbarSupportedContent">
                @auth
                    @php
                        $unreadMessagesCount = \App\Models\Message::where('recipient_id', auth()->id())
                            ->whereNull('read_at')
                            ->count();

                    @endphp

                    {{-- Enlaces de navegación autenticados --}}
                    <ul class="flex flex-col lg:flex-row lg:space-x-8 mt-4 lg:mt-0 w-full lg:w-auto">
                        <li class="mb-2 lg:mb-0">
                            <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                href="{{ route('dashboard') }}">Inicio</a>
                        </li>

                        @role('admin')
                            <!-- Botón ya existente: Gestión Usuarios -->
                            <li class="mb-2 lg:mb-0">
                                <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                    href="{{ route('admin.users.index') }}">
                                    <i class="bi bi-people-fill"></i> Gestión Usuarios
                                </a>
                            </li>

                            <!-- NUEVO BOTÓN: Gestión Empleadores -->
                            <li class="mb-2 lg:mb-0">
                                <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                    href="{{ route('admin.employers.index') }}">
                                    <i class="bi bi-building"></i> Gestión Empleadores
                                </a>
                            </li>
                        @endrole




                        @role('graduate')
                            <li class="mb-2 lg:mb-0">
                                <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                    href="{{ route('graduate.surveys.index') }}">Responder Encuestas</a>
                            </li>
                        @endrole

                        @role('employer')
                            <li class="mb-2 lg:mb-0">
                                <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                    href="{{ route('employer.profile.show') }}">
                                    <i class="bi bi-person-circle mr-1"></i> Perfil Empresa
                                </a>

                            </li>
                            <li class="mb-2 lg:mb-0">
                                <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                    href="{{ route('employer.graduates') }}">Buscar egresados</a>
                            </li>
                        @endrole

                        {{-- Enlace a Mensajes --}}
                        <li class="mb-2 lg:mb-0">
                            <a href="{{ route('messages.inbox') }}"
                                class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200">
                                Mensajes
                                @if ($unreadMessagesCount > 0)
                                    <span
                                        class="ml-1 inline-block bg-red-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full">
                                        {{ $unreadMessagesCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    </ul>

                    {{-- Enlaces del lado derecho --}}
                    <ul class="flex flex-col lg:flex-row lg:space-x-8 mt-4 lg:mt-0 lg:ml-auto">
                        @role('graduate')
                            <li class="mb-2 lg:mb-0">
                                <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                    href="{{ route('graduate.profile.show') }}">Perfil Egresado</a>
                            </li>
                        @endrole

                        <li class="mb-2 lg:mb-0">
                            <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                href="{{ route('profile.edit') }}">Configuración</a>
                        </li>

                        <li class="mb-2 lg:mb-0">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200 focus:outline-none">
                                    Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                @else
                    {{-- Navegación para visitantes --}}
                    <ul class="flex flex-col lg:flex-row lg:space-x-8 mt-4 lg:mt-0 lg:ml-auto">
                        <li class="mb-2 lg:mb-0">
                            <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                href="{{ route('login') }}">Ingresar</a>
                        </li>
                        <li class="mb-2 lg:mb-0">
                            <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                href="{{ route('register') }}">Registrarse</a>
                        </li>
                    </ul>
                @endauth
            </div>
        </div>
        </div>
    </nav>

    {{-- Main content --}}
    <main class="container mx-auto px-4 mt-8 mb-12 flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-carbon text-text-inverse py-8 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Instituto Superior Universitario Tecnológico Sucre.</p>
            <p class="text-sm mt-2">"Tu camino hacia el éxito académico y educación profesional"</p>
        </div>
    </footer>

    {{-- JS para navegación móvil --}}
    <script>
        document.getElementById('navbar-toggle').addEventListener('click', function() {
            const navContent = document.getElementById('navbarSupportedContent');
            navContent.classList.toggle('hidden');
        });
    </script>

    {{-- Auto logout por inactividad --}}
    @auth
        <script>
            (function() {
                const TIEMPO_INACTIVIDAD_TOTAL = 20 * 60 * 1000;
                const TIEMPO_AVISO = 1 * 60 * 1000;

                let timeoutCerrarSesion;
                let timeoutMostrarAviso;

                function crearModalAviso() {
                    if (document.getElementById('modal-inactividad')) return;

                    const modal = document.createElement('div');
                    modal.id = 'modal-inactividad';
                    modal.style.position = 'fixed';
                    modal.style.top = '0';
                    modal.style.left = '0';
                    modal.style.width = '100vw';
                    modal.style.height = '100vh';
                    modal.style.backgroundColor = 'rgba(0,0,0,0.6)';
                    modal.style.display = 'flex';
                    modal.style.justifyContent = 'center';
                    modal.style.alignItems = 'center';
                    modal.style.zIndex = '9999';

                    modal.innerHTML = `
                        <div style="background: white; padding: 2rem; border-radius: 8px; max-width: 400px; text-align: center; font-family: sans-serif;">
                            <h2 style="margin-bottom: 1rem;">Sesión próxima a cerrarse</h2>
                            <p>Tu sesión cerrará en 1 minuto por inactividad. ¿Deseas continuar conectado?</p>
                            <button id="btn-continuar-sesion" style="margin-top:1rem; padding: 0.5rem 1rem; cursor: pointer;">Continuar sesión</button>
                        </div>
                    `;

                    document.body.appendChild(modal);

                    document.getElementById('btn-continuar-sesion').addEventListener('click', () => {
                        resetTimeout();
                        ocultarModal();
                    });
                }

                function ocultarModal() {
                    const modal = document.getElementById('modal-inactividad');
                    if (modal) {
                        modal.remove();
                    }
                }

                function cerrarSesion() {
                    fetch("{{ route('logout') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Error en el cierre de sesión');
                            window.location.href = "{{ route('login') }}";
                        })
                        .catch(error => {
                            alert('No se pudo cerrar la sesión automáticamente. Por favor, cierra sesión manualmente.');
                            console.error('Error en logout automático:', error);
                        });
                }

                function resetTimeout() {
                    ocultarModal();
                    clearTimeout(timeoutCerrarSesion);
                    clearTimeout(timeoutMostrarAviso);

                    timeoutMostrarAviso = setTimeout(() => crearModalAviso(), TIEMPO_INACTIVIDAD_TOTAL - TIEMPO_AVISO);
                    timeoutCerrarSesion = setTimeout(() => cerrarSesion(), TIEMPO_INACTIVIDAD_TOTAL);
                }

                ['mousemove', 'keydown', 'scroll', 'touchstart'].forEach(evento =>
                    window.addEventListener(evento, resetTimeout, true)
                );

                resetTimeout();
            })
            ();
        </script>
    @endauth
    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

    <!-- Tom Select JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    @yield('scripts')
</body>

</html>
