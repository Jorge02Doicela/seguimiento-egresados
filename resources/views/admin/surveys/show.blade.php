@extends('layouts.app')

@section('title', 'Responder Encuesta')

@section('content')
    <h2>{{ $survey->title }}</h2>

    <form method="POST" action="{{ route('graduate.surveys.answers.store', $survey) }}">
        @csrf

        @foreach ($survey->questions as $question)
            <div class="mb-3">
                <label class="form-label">{{ $question->question_text }}</label>

                @php
                    $options = $question->options ?? [];
                    if (is_string($options)) {
                        $options = json_decode($options, true) ?? [];
                    }
                @endphp

                @if ($question->type === 'option')
                    @foreach ($options as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                value="{{ $option }}" required>
                            <label class="form-check-label">{{ $option }}</label>
                        </div>
                    @endforeach
                @elseif($question->type === 'checkbox')
                    @foreach ($options as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="answers[{{ $question->id }}][]"
                                value="{{ $option }}">
                            <label class="form-check-label">{{ $option }}</label>
                        </div>
                    @endforeach
                @elseif($question->type === 'boolean')
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="Sí"
                            required>
                        <label class="form-check-label">Sí</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="No"
                            required>
                        <label class="form-check-label">No</label>
                    </div>
                @elseif($question->type === 'scale')
                    <select name="answers[{{ $question->id }}]" class="form-select" required>
                        <option value="">Selecciona</option>
                        @for ($i = $question->scale_min ?? 1; $i <= ($question->scale_max ?? 5); $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                @elseif($question->type === 'text')
                    <textarea name="answers[{{ $question->id }}]" class="form-control" rows="3" required></textarea>
                @endif
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Enviar respuestas</button>
    </form>

@endsection
