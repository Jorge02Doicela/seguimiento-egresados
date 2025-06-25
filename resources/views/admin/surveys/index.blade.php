@extends('layouts.app')

@section('title', 'Lista de Encuestas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Encuestas</h2>
    <a href="{{ route('admin.surveys.create') }}" class="btn btn-primary">Crear nueva encuesta</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Título</th>
            <th>Preguntas</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($surveys as $survey)
            <tr>
                <td>{{ $survey->title }}</td>
                <td>{{ $survey->questions->count() }}</td>
                <td>
                    <a href="{{ route('admin.surveys.show', $survey) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('admin.surveys.edit', $survey) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('admin.surveys.destroy', $survey) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro de eliminar esta encuesta?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="3">No hay encuestas creadas.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $surveys->links() }}
@endsection
