<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Gestión Egresados')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

    @auth
    @if(auth()->user()->hasRole('graduate'))
        @php
            $unreadSurveyCount = auth()->user()->notifications()
                ->whereNull('read_at')
                ->where('type', 'App\Notifications\NewSurveyNotification')
                ->count();
        @endphp

        @if($unreadSurveyCount > 0)
            <div class="alert alert-info text-center mb-0">
                Tienes {{ $unreadSurveyCount }} notificación(es) nueva(s).
                <a href="{{ route('notifications.index') }}">Ver notificaciones</a>
            </div>
        @endif
    @endif
@endauth

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Gestión Egresados</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @auth
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>

                        @role('admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.surveys.index') }}">Encuestas</a></li>
                        @endrole

                        @role('graduate')
                            <li class="nav-item"><a class="nav-link" href="{{ route('graduate.home') }}">Egresado</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('graduate.surveys.index') }}">Responder Encuestas</a></li>
                        @endrole

                        @role('employer')
                            <li class="nav-item"><a class="nav-link" href="{{ route('employer.home') }}">Empleador</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('employer.graduates') }}">Buscar Egresados</a></li>
                        @endrole
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            @if(auth()->user()->hasRole('graduate'))
                                <a class="nav-link" href="{{ route('graduate.profile.edit') }}">Perfil</a>
                            @elseif(auth()->user()->hasRole('admin'))
                                <a class="nav-link" href="{{ route('profile.edit') }}">Perfil</a>
                            @elseif(auth()->user()->hasRole('employer'))
                                <a class="nav-link" href="#">Perfil empleador</a> {{-- Aquí podrías poner su ruta personalizada si existe --}}
                            @endif
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link" style="display:inline; padding:0; border:none; cursor:pointer;">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Ingresar</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                    </ul>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
