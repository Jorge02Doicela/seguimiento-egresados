<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel de Administración')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @include('partials.navbar-admin') {{-- Opcional: tu navbar para admin --}}
    <main class="container py-4">
        @yield('content')
    </main>
    @yield('scripts')

</body>

</html>
