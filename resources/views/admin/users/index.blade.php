@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
    <div class="container py-4">
        <h1>Usuarios</h1>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Botón para crear nuevo usuario --}}
        <a href="{{ route('admin.users.create') }}" class="btn btn-success mb-3">+ Nuevo Usuario</a>

        {{-- Formulario de búsqueda y filtro por rol --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3 d-flex gap-2 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                placeholder="Buscar por nombre o email">

            <select name="role_id" class="form-select">
                <option value="">-- Rol --</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @selected(request('role_id') == $role->id)>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>

            <button class="btn btn-outline-primary">Filtrar</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        </form>

        {{-- Tabla de usuarios --}}
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">Editar</a>

                            @if (auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Eliminar usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </form>

                                <form action="{{ route('admin.users.toggle-block', $user) }}" method="POST"
                                    class="d-inline ms-1">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="btn btn-sm {{ $user->is_blocked ? 'btn-danger' : 'btn-success' }}"
                                        onclick="return confirm('¿Estás seguro de {{ $user->is_blocked ? 'desbloquear' : 'bloquear' }} este usuario?')">
                                        {{ $user->is_blocked ? 'Desbloquear' : 'Bloquear' }}
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">No puedes eliminarte</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No se encontraron usuarios.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        {{-- Paginación --}}
        {{ $users->withQueryString()->links() }}
    </div>
@endsection
