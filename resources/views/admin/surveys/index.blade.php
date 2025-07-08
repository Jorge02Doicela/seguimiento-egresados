@extends('layouts.admin')

@section('title', 'Listado de Encuestas')

@section('content')
    <h1 class="mb-4">Encuestas</h1>

    <a href="{{ route('admin.surveys.create') }}" class="btn btn-success mb-3">Nueva Encuesta</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Carrera</th>
                <th>Título</th>
                <th>Activo</th>
                <th>Periodo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($surveys as $survey)
                <tr>
                    <td>{{ $survey->id }}</td>
                    <td>{{ $survey->career->name ?? 'N/A' }}</td>
                    <td>{{ $survey->title }}</td>
                    <td>
                        @if ($survey->is_active)
                            <span class="badge bg-success">Sí</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </td>
                    <td>
                        {{ $survey->start_date ? \Carbon\Carbon::parse($survey->start_date)->format('d/m/Y') : '-' }}
                        -
                        {{ $survey->end_date ? \Carbon\Carbon::parse($survey->end_date)->format('d/m/Y') : '-' }}
                    </td>
                    <td>
                        <a href="{{ route('admin.surveys.edit', $survey) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('admin.surveys.destroy', $survey) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('¿Eliminar esta encuesta? Esta acción no se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                        <a href="{{ route('admin.surveys.clone', $survey) }}" class="btn btn-warning btn-sm">Clonar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay encuestas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $surveys->links() }}
@endsection
