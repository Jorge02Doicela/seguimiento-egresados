@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-text-primary mb-6">{{ $survey->title }}</h1>

        @if ($hasAnswered)
            <div class="bg-info-lighter text-info-dark px-4 py-3 rounded-lg mb-6 shadow-sm" role="alert">
                Ya has respondido esta encuesta.
            </div>
            <a href="{{ route('graduate.surveys.index') }}"
                class="btn bg-gray-silver text-white hover:bg-gray-slate focus:ring-gray-silver px-6 py-3">Volver a
                encuestas</a>
        @else
            <form action="{{ route('graduate.surveys.submit', $survey) }}" method="POST"
                class="bg-white p-8 rounded-2xl shadow-primary-lg max-w-2xl mx-auto">
                @csrf

                @foreach ($survey->questions as $question)
                    <div class="mb-6 border-b border-gray-lighter pb-6 last:border-b-0 last:pb-0">
                        <label class="block text-text-secondary text-base font-medium mb-3">
                            <strong class="text-text-primary">{{ $question->question_text }}</strong>
                        </label>

                        @if ($question->type === 'option')
                            <div class="space-y-2">
                                @foreach (json_decode($question->options) as $option)
                                    <div class="flex items-center">
                                        <input type="radio" name="answers[{{ $question->id }}]"
                                            value="{{ $option }}" required
                                            class="form-radio text-primary focus:ring-primary h-4 w-4">
                                        <label class="ml-2 text-text-secondary">{{ $option }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @elseif ($question->type === 'checkbox')
                            <div class="space-y-2">
                                @foreach (json_decode($question->options) as $option)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="answers[{{ $question->id }}][]"
                                            value="{{ $option }}"
                                            class="form-checkbox text-primary focus:ring-primary rounded h-4 w-4">
                                        <label class="ml-2 text-text-secondary">{{ $option }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @elseif ($question->type === 'scale')
                            <select name="answers[{{ $question->id }}]" required class="form-select mt-1 block w-full">
                                <option value="">Seleccione</option>
                                @for ($i = $question->scale_min; $i <= $question->scale_max; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        @elseif ($question->type === 'boolean')
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="Sí" required
                                        class="form-radio text-primary focus:ring-primary h-4 w-4">
                                    <label class="ml-2 text-text-secondary">Sí</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="No" required
                                        class="form-radio text-primary focus:ring-primary h-4 w-4">
                                    <label class="ml-2 text-text-secondary">No</label>
                                </div>
                            </div>
                        @endif

                        @error('answers.' . $question->id)
                            <div class="text-error text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                <button type="submit" class="btn btn-success px-6 py-3 shadow-success hover:shadow-success-dark">Enviar
                    respuestas</button>
            </form>
        @endif
    </div>
@endsection
