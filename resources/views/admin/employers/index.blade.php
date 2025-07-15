@extends('layouts.app')

@section('title', 'Gestión de Empleadores')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-text-primary mb-6">Gestión de Empleadores</h1>

        @if (session('success'))
            <div class="bg-success-lighter text-success-dark px-4 py-3 rounded-lg mb-6 shadow-sm" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-2xl overflow-hidden mb-8">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-light border-b border-gray-lighter">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">ID
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                            Empresa</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                            Usuario (email)</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                            Estado</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                            Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employers as $employer)
                        <tr class="border-b border-gray-lighter hover:bg-bg-secondary transition-colors duration-200">
                            <td class="px-5 py-4 text-sm text-text-secondary">{{ $employer->id }}</td>
                            <td class="px-5 py-4 text-sm text-text-secondary">{{ $employer->company_name }}</td>
                            <td class="px-5 py-4 text-sm text-text-secondary">{{ $employer->user->email ?? 'N/A' }}</td>
                            <td class="px-5 py-4 text-sm text-text-secondary">
                                @if ($employer->is_verified)
                                    <span class="badge badge-success">Verificado</span>
                                @else
                                    <span class="badge badge-warning">Pendiente</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-sm flex flex-wrap gap-2 items-center">
                                <a href="{{ route('admin.employers.show', $employer) }}"
                                    class="btn btn-sm bg-primary text-white hover:bg-primary-dark focus:ring-primary"
                                    title="Ver detalles">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.employers.edit', $employer) }}"
                                    class="btn btn-sm bg-accent text-white hover:bg-accent-dark focus:ring-accent"
                                    title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.employers.verify', $employer) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="btn btn-sm bg-success text-white hover:bg-success-dark focus:ring-success"
                                        onclick="return confirm('¿Confirmas cambiar el estado de verificación?')"
                                        title="Cambiar estado verificación">
                                        @if ($employer->is_verified)
                                            <i class="bi bi-check2-circle"></i>
                                        @else
                                            <i class="bi bi-x-circle"></i>
                                        @endif
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-4 text-sm text-text-muted text-center">No hay empleadores
                                registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $employers->links() }}
        </div>
    </div>
@endsection
