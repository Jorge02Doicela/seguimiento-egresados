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

                        $user = auth()->user();
                        $careerId = $user->graduate->career_id ?? null;
                        $pendingCount = 0;

                        if ($careerId) {
                            $pendingCount = \App\Models\Survey::where('career_id', $careerId)
                                ->where('is_active', true)
                                ->where(function ($query) {
                                    $query->whereNull('start_date')->orWhere('start_date', '<=', now());
                                })
                                ->where(function ($query) {
                                    $query->whereNull('end_date')->orWhere('end_date', '>=', now());
                                })
                                // Encuestas que NO tienen respuestas del usuario
                                ->whereDoesntHave('questions.answers', function ($query) use ($user) {
                                    $query->where('user_id', $user->id);
                                })
                                ->count();
                        }
                    @endphp

                    {{-- Enlaces de navegación autenticados --}}
                    <ul class="flex flex-col lg:flex-row lg:space-x-8 mt-4 lg:mt-0 w-full lg:w-auto">
                        <li class="mb-2 lg:mb-0">
                            <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                href="{{ route('dashboard') }}">
                                <i class="bi bi-house-door-fill mr-1"></i> Inicio
                            </a>
                        </li>

                        @role('admin')
                            <li class="mb-2 lg:mb-0">
                                <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                    href="{{ route('admin.users.index') }}">
                                    <i class="bi bi-people-fill mr-1"></i> Gestión Usuarios
                                </a>
                            </li>
                            <li class="mb-2 lg:mb-0">
                                <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                    href="{{ route('admin.employers.index') }}">
                                    <i class="bi bi-building mr-1"></i> Gestión Empleadores
                                </a>
                            </li>
                            <li class="mb-2 lg:mb-0">
                                <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                    href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 mr-1"></i> Dashboard Admin
                                </a>
                            </li>
                            <li class="mb-2 lg:mb-0">
                                <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                    href="{{ route('admin.surveys.index') }}">
                                    <i class="bi bi-list-check mr-1"></i> Encuestas
                                </a>
                            </li>
                        @endrole

                        @role('graduate')
                            {{-- Enlace para encuestas específicas por carrera --}}
                            <li class="mb-2 lg:mb-0">
                                <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                    href="{{ route('graduate.surveys.index') }}">
                                    <i class="bi bi-clipboard-check mr-1"></i> Responder Encuestas
                                    @if ($pendingCount > 0)
                                        <span
                                            class="ml-1 inline-block bg-red-600 text-xs px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                                    @endif
                                </a>
                            </li>
                        @endrole
                        @role('employer')
                            <li class="mb-2 lg:mb-0">
                                <a href="{{ route('employer.graduates') }}"
                                    class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200">
                                    <i class="bi bi-search mr-1"></i> Buscar Egresados
                                </a>
                            </li>
                        @endrole
                        @role('employer')
                            <li class="mb-2 lg:mb-0">
                                <a href="{{ route('employer.profile.show') }}"
                                    class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200">
                                    <i class="bi bi-person-fill mr-1"></i> Perfil Empleador
                                </a>
                            </li>
                        @endrole


                        {{-- Enlace a Mensajes --}}
                        <li class="mb-2 lg:mb-0">
                            <a href="{{ route('messages.inbox') }}"
                                class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200">
                                <i class="bi bi-chat-left-text-fill mr-1"></i> Mensajes
                                @if ($unreadMessagesCount > 0)
                                    <span
                                        class="ml-1 inline-block bg-red-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full">
                                        {{ $unreadMessagesCount }}
                                    </span>
                                @endif
                            </a>
                        </li>

                        {{-- Enlace a Notificaciones --}}
                        <li class="mb-2 lg:mb-0">
                            <a href="{{ route('notifications.index') }}"
                                class="relative block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200">
                                <i class="bi bi-bell-fill mr-1"></i> Notificaciones
                                @if (Auth::user()->unreadNotifications->count())
                                    <span
                                        class="absolute top-2 right-2 inline-block w-2 h-2 bg-red-600 rounded-full"></span>
                                @endif
                            </a>
                        </li>
                    </ul>

                    {{-- Enlaces del lado derecho --}}
                    <ul class="flex flex-col lg:flex-row lg:space-x-8 mt-4 lg:mt-0 lg:ml-auto">
                        @role('graduate')
                            <li class="mb-2 lg:mb-0">
                                <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                    href="{{ route('graduate.profile.show') }}">
                                    <i class="bi bi-person-fill mr-1"></i> Perfil Egresado
                                </a>
                            </li>
                        @endrole

                        @role('graduate|employer')
                            <li class="mb-2 lg:mb-0">
                                <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                    href="{{ route('profile.edit') }}">
                                    <i class="bi bi-gear-fill mr-1"></i> Configuración
                                </a>
                            </li>
                        @endrole

                        <li class="mb-2 lg:mb-0">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200 focus:outline-none">
                                    <i class="bi bi-box-arrow-right mr-1"></i> Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                @else
                    {{-- Navegación para visitantes --}}
                    <ul class="flex flex-col lg:flex-row lg:space-x-8 mt-4 lg:mt-0 lg:ml-auto">
                        <li class="mb-2 lg:mb-0">
                            <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right mr-1"></i> Ingresar
                            </a>
                        </li>
                        <li class="mb-2 lg:mb-0">
                            <a class="block py-2 px-3 rounded text-white hover:bg-accent transition-colors duration-200"
                                href="{{ route('register') }}">
                                <i class="bi bi-person-plus-fill mr-1"></i> Registrarse
                            </a>
                        </li>
                    </ul>
                @endauth
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
