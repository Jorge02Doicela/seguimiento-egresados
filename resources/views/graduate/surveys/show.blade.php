@extends('layouts.app')

@section('title', 'Responder Encuesta')

@section('content')
    <h2>{{ $survey->title }}</h2>
    <p>{{ $survey->description }}</p>

    <form method="POST" action="{{ route('graduate.surveys.answers.store', $survey) }}">
        @csrf

        @foreach ($survey->questions as $question)
            <div class="mb-4">
                <label class="form-label fw-bold">{{ $question->question_text }}</label>

                @php
                    $options = $question->options ? json_decode($question->options, true) : [];
                @endphp

                @if ($question->type === 'option')
                    {{-- Opción múltiple (radio buttons) --}}
                    @foreach ($options as $option)
                        <div class="form-check">
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}"
                                class="form-check-input" required>
                            <label class="form-check-label">{{ $option }}</label>
                        </div>
                    @endforeach
                @elseif ($question->type === 'checkbox')
                    {{-- Selección múltiple (checkboxes) --}}
                    @foreach ($options as $option)
                        <div class="form-check">
                            <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option }}"
                                class="form-check-input">
                            <label class="form-check-label">{{ $option }}</label>
                        </div>
                    @endforeach
                @elseif ($question->type === 'scale')
                    {{-- Escala numérica --}}
                    <select name="answers[{{ $question->id }}]" class="form-select" required>
                        <option value="">Seleccione</option>
                        @for ($i = $question->scale_min ?? 1; $i <= ($question->scale_max ?? 5); $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                @elseif ($question->type === 'boolean')
                    {{-- Sí/No --}}
                    <select name="answers[{{ $question->id }}]" class="form-select" required>
                        <option value="">Seleccione</option>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>
                @endif

                @error('answers.' . $question->id)
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Enviar respuestas</button>
    </form>
@endsection
