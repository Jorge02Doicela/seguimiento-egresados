@extends('layouts.app')

@section('title', 'Encuestas Disponibles')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Encuestas Disponibles</h1>

    @if (session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif

    @if ($surveys->isEmpty())
        <p>No hay encuestas disponibles por el momento.</p>
    @else
        @foreach ($surveys as $survey)
            <div class="p-4 border rounded mb-4 shadow-sm">
                <h3 class="text-lg font-semibold mb-1">{{ $survey->title }}</h3>

                @if ($survey->career_id == 0)
                    <span class="inline-block bg-blue-600 text-white text-xs px-2 py-1 rounded mb-2">General</span>
                @endif

                @if ($survey->description)
                    <p class="mb-2">{{ $survey->description }}</p>
                @endif

                <a href="{{ route('graduate.surveys.show', $survey) }}"
                    class="inline-block bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition">
                    Responder Encuesta
                </a>
            </div>
        @endforeach
    @endif
@endsection
