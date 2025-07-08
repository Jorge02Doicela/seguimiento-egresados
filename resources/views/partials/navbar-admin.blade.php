<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin - ISUS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNavbar">
        <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.surveys.index') }}">Encuestas</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.reports') }}">Reportes</a></li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Volver</a></li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light ms-2">Salir</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
