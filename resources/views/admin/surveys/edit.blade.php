@extends('layouts.app')

@section('title', 'Editar Encuesta')

@section('content')
    <h2>Editar Encuesta: {{ $survey->title }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.surveys.update', $survey) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Título:</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $survey->title) }}" required>
        </div>

        <div class="mb-3">
            <label>Descripción:</label>
            <textarea name="description" class="form-control">{{ old('description', $survey->description) }}</textarea>
        </div>

        <hr>
        <h5>Preguntas</h5>
        <div id="question-list">
            @foreach ($survey->questions as $index => $question)
                <div class="border p-3 mb-3">
                    <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id }}">
                    <div class="mb-2">
                        <label>Texto de la pregunta:</label>
                        <input type="text" name="questions[{{ $index }}][question_text]" class="form-control"
                            value="{{ $question->question_text }}" required>
                    </div>

                    <div class="mb-2">
                        <label>Tipo:</label>
                        <select name="questions[{{ $index }}][type]" class="form-select"
                            onchange="toggleOptions(this, {{ $index }})" required>
                            <option value="option" @selected($question->type == 'option')>Opción múltiple</option>
                            <option value="scale" @selected($question->type == 'scale')>Escala</option>
                            <option value="text" @selected($question->type == 'text')>Texto libre</option>
                        </select>
                    </div>

                    <div class="mb-2 {{ $question->type !== 'option' ? 'd-none' : '' }}" id="options-{{ $index }}">
                        <label>Opciones (separadas por coma):</label>
                        <input type="text" name="questions[{{ $index }}][options][]" class="form-control"
                            value="{{ is_array($question->options) ? implode(',', $question->options) : '' }}">
                    </div>

                    <div class="row {{ $question->type !== 'scale' ? 'd-none' : '' }}" id="scale-{{ $index }}">
                        <div class="col">
                            <label>Escala mínima:</label>
                            <input type="number" name="questions[{{ $index }}][scale_min]" class="form-control"
                                min="1" max="10" value="{{ $question->scale_min }}">
                        </div>
                        <div class="col">
                            <label>Escala máxima:</label>
                            <input type="number" name="questions[{{ $index }}][scale_max]" class="form-control"
                                min="1" max="10" value="{{ $question->scale_max }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Encuesta</button>
    </form>

    <script>
        function toggleOptions(select, index) {
            document.getElementById(`options-${index}`).classList.add('d-none');
            document.getElementById(`scale-${index}`).classList.add('d-none');

            if (select.value === 'option') {
                document.getElementById(`options-${index}`).classList.remove('d-none');
            }
            if (select.value === 'scale') {
                document.getElementById(`scale-${index}`).classList.remove('d-none');
            }
        }
    </script>
@endsection
