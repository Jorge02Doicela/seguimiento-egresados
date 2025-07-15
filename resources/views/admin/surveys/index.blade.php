@extends('layouts.app')

@section('title', 'Listado de Encuestas')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-text-primary mb-6">Listado de Encuestas</h1>

        <div class="mb-4 flex flex-wrap gap-3 items-center">
            <a href="{{ route('admin.surveys.dashboard') }}"
                class="btn btn-primary px-6 py-3 shadow-primary hover:shadow-primary-dark">
                Estadísticas de Encuestas
            </a>
            <a href="{{ route('admin.surveys.create') }}"
                class="btn btn-accent px-6 py-3 shadow-accent hover:shadow-accent-dark">Crear Nueva Encuesta</a>
        </div>


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
                            Título</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                            Carrera</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                            Activo</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">Fecha
                            Inicio</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">Fecha
                            Fin</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                            Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($surveys as $survey)
                        <tr class="border-b border-gray-lighter hover:bg-bg-secondary transition-colors duration-200">
                            <td class="px-5 py-4 text-sm text-text-secondary">{{ $survey->id }}</td>
                            <td class="px-5 py-4 text-sm text-text-secondary">{{ $survey->title }}</td>
                            <td class="px-5 py-4 text-sm text-text-secondary">{{ $survey->career->name ?? '-' }}</td>
                            <td class="px-5 py-4 text-sm text-text-secondary">{{ $survey->is_active ? 'Sí' : 'No' }}</td>
                            <td class="px-5 py-4 text-sm text-text-secondary">
                                {{ $survey->start_date ? $survey->start_date->format('Y-m-d') : '-' }}</td>
                            <td class="px-5 py-4 text-sm text-text-secondary">
                                {{ $survey->end_date ? $survey->end_date->format('Y-m-d') : '-' }}</td>
                            <td class="px-5 py-4 text-sm flex flex-wrap gap-2 items-center">
                                <a href="{{ route('admin.surveys.edit', $survey) }}"
                                    class="btn btn-sm bg-accent text-white hover:bg-accent-dark focus:ring-accent">Editar</a>

                                <form action="{{ route('admin.surveys.destroy', $survey) }}" method="POST" class="inline"
                                    onsubmit="return confirm('¿Eliminar encuesta?');">
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

        <div class="mt-6">
            {{ $surveys->links() }}
        </div>
    </div>
@endsection
