@extends('layouts.app')

@section('content')
    <h1>{{ $survey->title }}</h1>

    @if ($hasAnswered)
        <div class="alert alert-info">Ya has respondido esta encuesta.</div>
        <a href="{{ route('graduate.surveys.index') }}" class="btn btn-secondary">Volver a encuestas</a>
    @else
        <form action="{{ route('graduate.surveys.submit', $survey) }}" method="POST">
            @csrf

            @foreach ($survey->questions as $question)
                <div class="mb-4">
                    <label class="form-label"><strong>{{ $question->question_text }}</strong></label><br>

                    @if ($question->type === 'option')
                        @foreach (json_decode($question->options) as $option)
                            <div>
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" required>
                                <label>{{ $option }}</label>
                            </div>
                        @endforeach
                    @elseif ($question->type === 'checkbox')
                        @foreach (json_decode($question->options) as $option)
                            <div>
                                <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option }}">
                                <label>{{ $option }}</label>
                            </div>
                        @endforeach
                    @elseif ($question->type === 'scale')
                        <select name="answers[{{ $question->id }}]" required>
                            <option value="">Seleccione</option>
                            @for ($i = $question->scale_min; $i <= $question->scale_max; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    @elseif ($question->type === 'boolean')
                        <div>
                            <input type="radio" name="answers[{{ $question->id }}]" value="Sí" required>
                            <label>Sí</label>
                        </div>
                        <div>
                            <input type="radio" name="answers[{{ $question->id }}]" value="No" required>
                            <label>No</label>
                        </div>
                    @endif

                    @error('answers.' . $question->id)
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach

            <button type="submit" class="btn btn-success">Enviar respuestas</button>
        </form>
    @endif
@endsection
