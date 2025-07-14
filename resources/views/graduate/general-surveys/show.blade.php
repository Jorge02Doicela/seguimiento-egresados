@extends('layouts.app')

@section('title', $survey->title)

@section('content')
    <h1 class="text-2xl font-bold mb-6">{{ $survey->title }}</h1>
    <p class="mb-6">{{ $survey->description }}</p>

    <form method="POST" action="{{ route('graduate.general-surveys.submit', $survey) }}">
        @csrf

        @foreach ($survey->questions as $question)
            <div class="mb-4">
                <label class="block font-semibold mb-1">{{ $question->text }}</label>

                @if ($question->type == 'multiple_choice')
                    @foreach ($question->options as $option)
                        <label class="inline-flex items-center mr-4">
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" required>
                            <span class="ml-2">{{ $option->text }}</span>
                        </label>
                    @endforeach
                @elseif($question->type == 'text')
                    <input type="text" name="answers[{{ $question->id }}]" class="border rounded p-2 w-full" required>
                @endif
                {{-- Añade otros tipos de preguntas según tu modelo --}}
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Enviar Respuestas</button>
    </form>
@endsection
