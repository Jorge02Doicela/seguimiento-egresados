@extends('layouts.admin')

@section('title', 'Listado de Encuestas')

@section('content')

    <h1 class="text-2xl font-bold mb-4">Listado de Encuestas</h1>
    <a href="{{ route('admin.surveys.dashboard') }}" class="btn btn-primary">
        Estadísticas de Encuestas
    </a>
    <br>
    <br>

    <a href="{{ route('admin.surveys.create') }}" class="btn btn-primary mb-4">Crear Nueva Encuesta</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">Título</th>
                <th class="border border-gray-300 px-4 py-2">Carrera</th>
                <th class="border border-gray-300 px-4 py-2">Activo</th>
                <th class="border border-gray-300 px-4 py-2">Fecha Inicio</th>
                <th class="border border-gray-300 px-4 py-2">Fecha Fin</th>
                <th class="border border-gray-300 px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($surveys as $survey)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $survey->id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $survey->title }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $survey->career->name ?? '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $survey->is_active ? 'Sí' : 'No' }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $survey->start_date ? $survey->start_date->format('Y-m-d') : '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $survey->end_date ? $survey->end_date->format('Y-m-d') : '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{ route('admin.surveys.edit', $survey) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('admin.surveys.destroy', $survey) }}" method="POST" class="inline-block"
                            onsubmit="return confirm('¿Eliminar encuesta?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $surveys->links() }}

@endsection
