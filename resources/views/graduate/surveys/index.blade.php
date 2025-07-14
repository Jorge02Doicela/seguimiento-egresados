@extends('layouts.app')

@section('content')
    <h1>Encuestas disponibles</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($surveys->isEmpty())
        <p>No hay encuestas activas para tu carrera en este momento.</p>
    @else
        <ul>
            @foreach ($surveys as $survey)
                <li>
                    <h3>{{ $survey->title }}</h3>
                    <p>{{ $survey->description }}</p>
                    <a href="{{ route('graduate.surveys.show', $survey) }}" class="btn btn-primary">Responder</a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
