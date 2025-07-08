@extends('layouts.app')

@section('title', 'Detalles de Encuesta')

@section('content')
    <h2>Detalles de la Encuesta</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $survey->title }}</h5>
            <p class="card-text">{{ $survey->description }}</p>
            <a href="{{ route('admin.surveys.edit', $survey) }}" class="btn btn-sm btn-warning">Editar</a>
            <form action="{{ route('admin.surveys.destroy', $survey) }}" method="POST" class="d-inline"
                onsubmit="return confirm('¿Estás seguro de eliminar esta encuesta?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
            </form>
        </div>
    </div>

    <h4>Preguntas:</h4>
    @foreach ($survey->questions as $question)
        <div class="mb-3 p-3 border rounded bg-light">
            <strong>{{ $loop->iteration }}. {{ $question->question_text }}</strong><br>
            <span class="text-muted">Tipo: {{ ucfirst($question->type) }}</span>

            @if ($question->type === 'option' && is_array($question->options))
                <ul class="mt-2">
                    @foreach ($question->options as $opt)
                        <li>{{ $opt }}</li>
                    @endforeach
                </ul>
            @elseif ($question->type === 'scale')
                <p class="mt-2">Escala de {{ $question->scale_min }} a {{ $question->scale_max }}</p>
            @endif
        </div>
    @endforeach

    <a href="{{ route('admin.surveys.index') }}" class="btn btn-secondary mt-4">← Volver al listado</a>
@endsection
