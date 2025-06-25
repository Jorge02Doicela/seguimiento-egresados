@extends('layouts.app')

@section('title', 'Crear Encuesta')

@section('content')
<h2>Crear Nueva Encuesta</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Errores:</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.surveys.store') }}">
    @csrf

    <div class="mb-3">
        <label>Título:</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Descripción:</label>
        <textarea name="description" class="form-control"></textarea>
    </div>

    <hr>
    <h5>Preguntas</h5>
    <div id="question-list"></div>

    <button type="button" class="btn btn-secondary" onclick="addQuestion()">+ Añadir pregunta</button>

    <div class="mt-4">
        <button type="submit" class="btn btn-success">Guardar Encuesta</button>
    </div>
</form>

<script>
let questionIndex = 0;

function addQuestion() {
    const container = document.getElementById('question-list');

    const questionBlock = document.createElement('div');
    questionBlock.classList.add('border', 'p-3', 'mb-3');
    questionBlock.innerHTML = `
        <div class="mb-2">
            <label>Texto de la pregunta:</label>
            <input type="text" name="questions[${questionIndex}][question_text]" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Tipo:</label>
            <select name="questions[${questionIndex}][type]" class="form-select" onchange="toggleOptions(this, ${questionIndex})" required>
                <option value="">Selecciona tipo</option>
                <option value="option">Opción múltiple</option>
                <option value="scale">Escala (1-5)</option>
                <option value="text">Texto libre</option>
            </select>
        </div>
        <div class="mb-2 d-none" id="options-${questionIndex}">
            <label>Opciones (separadas por coma):</label>
            <input type="text" name="questions[${questionIndex}][options][]" class="form-control">
        </div>
        <div class="row d-none" id="scale-${questionIndex}">
            <div class="col">
                <label>Escala mínima:</label>
                <input type="number" name="questions[${questionIndex}][scale_min]" class="form-control" min="1" max="10">
            </div>
            <div class="col">
                <label>Escala máxima:</label>
                <input type="number" name="questions[${questionIndex}][scale_max]" class="form-control" min="1" max="10">
            </div>
        </div>
    `;
    container.appendChild(questionBlock);
    questionIndex++;
}

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
