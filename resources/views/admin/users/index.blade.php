@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-text-primary mb-6">Gestión de Usuarios</h1>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="bg-success-lighter text-success-dark px-4 py-3 rounded-lg mb-4 shadow-sm" role="alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Botón para crear nuevo usuario --}}
        <div class="mb-6">
            <a href="{{ route('admin.users.create') }}"
                class="btn btn-success px-6 py-3 rounded-xl shadow-success hover:shadow-success-dark">
                + Nuevo Usuario
            </a>
        </div>

        {{-- Formulario de búsqueda y filtro por rol --}}
        <form method="GET" action="{{ route('admin.users.index') }}"
            class="mb-8 flex flex-col sm:flex-row gap-4 items-center card p-6">
            <input type="text" name="search" value="{{ request('search') }}" class="form-input flex-grow"
                placeholder="Buscar por nombre o email">

            <select name="role_id" class="form-select">
                <option value="">-- Rol --</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @selected(request('role_id') == $role->id)>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-outline">Filtrar</button>
            <a href="{{ route('admin.users.index') }}"
                class="btn bg-gray-silver text-white hover:bg-gray-slate focus:ring-gray-silver">Limpiar</a>
        </form>

        {{-- Tabla de usuarios --}}
        <div class="bg-white shadow-md rounded-2xl overflow-hidden mb-8">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-light border-b border-gray-lighter">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                            Nombre
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b border-gray-lighter hover:bg-bg-secondary transition-colors duration-200">
                            <td class="px-5 py-4 text-sm text-text-secondary">
                                {{ $user->id }}
                            </td>
                            <td class="px-5 py-4 text-sm text-text-secondary">
                                {{ $user->name }}
                            </td>
                            <td class="px-5 py-4 text-sm text-text-secondary">
                                {{ $user->email }}
                            </td>
                            <td class="px-5 py-4 text-sm flex flex-wrap gap-2 items-center">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">Editar</a>

                                @if (auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                        onsubmit="return confirm('¿Eliminar usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm bg-error text-white hover:bg-error-dark focus:ring-error">Eliminar</button>
                                    </form>

                                    <form action="{{ route('admin.users.toggle-block', $user) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="btn btn-sm {{ $user->is_blocked ? 'bg-warning-dark' : 'bg-success' }} text-white {{ $user->is_blocked ? 'hover:bg-warning' : 'hover:bg-success-dark' }} focus:ring-primary"
                                            onclick="return confirm('¿Estás seguro de {{ $user->is_blocked ? 'desbloquear' : 'bloquear' }} este usuario?')">
                                            {{ $user->is_blocked ? 'Desbloquear' : 'Bloquear' }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-text-muted text-xs italic">No puedes eliminarte</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-4 text-sm text-text-muted text-center">No se encontraron
                                usuarios.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-6">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
@endsection
