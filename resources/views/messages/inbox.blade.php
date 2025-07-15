@extends('layouts.app')

@section('title', 'Bandeja de Entrada')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-text-primary mb-6">Bandeja de Entrada</h1>

        @if (session('success'))
            <div class="bg-success-lighter text-success-dark px-4 py-3 rounded-lg mb-6 shadow-sm" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex flex-wrap gap-3 items-center">
            <a href="{{ route('messages.create') }}"
                class="btn btn-primary px-6 py-3 shadow-primary hover:shadow-primary-dark">
                <i class="bi bi-pencil-square mr-2"></i> Nuevo Mensaje
            </a>

            @role('admin')
                <a href="{{ route('admin.messages.broadcast') }}"
                    class="btn btn-warning px-6 py-3 shadow-warning hover:shadow-warning-dark">
                    <i class="bi bi-megaphone-fill mr-2"></i> Mensaje Masivo
                </a>
            @endrole
        </div>

        @if ($messages->isEmpty())
            <div class="bg-info-lighter text-info-dark px-4 py-3 rounded-lg mb-6 shadow-sm" role="alert">
                No tienes mensajes.
            </div>
        @else
            <div class="bg-white shadow-md rounded-2xl overflow-hidden mb-8">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="bg-gray-light border-b border-gray-lighter">
                            <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                                De</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                                Contenido</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                                Fecha</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                                Estado</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                                Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $msg)
                            <tr
                                class="{{ $msg->read_at ? 'text-text-secondary' : 'bg-warning-lighter font-semibold text-text-primary' }} border-b border-gray-lighter hover:bg-bg-secondary transition-colors duration-200">
                                <td class="px-5 py-4 text-sm">{{ $msg->sender->name ?? 'Desconocido' }}</td>
                                <td class="px-5 py-4 text-sm truncate max-w-xs">
                                    {{ Str::limit($msg->content, 60) }}
                                </td>
                                <td class="px-5 py-4 text-sm">{{ $msg->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-5 py-4 text-sm">
                                    @if ($msg->read_at)
                                        <span class="badge badge-success">Leído</span>
                                    @else
                                        <span class="badge badge-warning">No leído</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-sm flex flex-wrap gap-2 items-center">
                                    <a href="{{ route('messages.show', $msg->id) }}" class="btn btn-sm btn-outline-primary">
                                        Ver
                                    </a>
                                    <form action="{{ route('messages.destroy', $msg->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('¿Estás seguro de eliminar este mensaje?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm bg-error text-white hover:bg-error-dark focus:ring-error">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
