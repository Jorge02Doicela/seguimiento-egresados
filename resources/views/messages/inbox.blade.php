@extends('layouts.app')

@section('title', 'Bandeja de Entrada')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Bandeja de Entrada</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('messages.create') }}" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i> Nuevo Mensaje
            </a>
        </div>

        @if ($messages->isEmpty())
            <div class="alert alert-info">No tienes mensajes.</div>
        @else
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>De</th>
                        <th>Contenido</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $msg)
                        <tr class="{{ $msg->read_at ? '' : 'table-warning fw-bold' }}">
                            <td>{{ $msg->sender->name ?? 'Desconocido' }}</td>
                            <td class="text-truncate" style="max-width: 300px;">
                                {{ Str::limit($msg->content, 60) }}
                            </td>
                            <td>{{ $msg->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if ($msg->read_at)
                                    <span class="badge bg-success">Leído</span>
                                @else
                                    <span class="badge bg-warning text-dark">No leído</span>
                                @endif

                            </td>
                            <td>
                                <a href="{{ route('messages.show', $msg->id) }}" class="btn btn-sm btn-outline-primary">
                                    Ver
                                </a>
                                <form action="{{ route('messages.destroy', $msg->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Estás seguro de eliminar este mensaje?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
