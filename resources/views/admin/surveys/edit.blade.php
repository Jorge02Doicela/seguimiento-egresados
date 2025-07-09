@extends('layouts.admin')

@section('title', 'Editar Encuesta')

@section('content')
    <h1>Editar Encuesta</h1>

    <a href="{{ route('admin.surveys.index') }}" class="btn btn-secondary mb-3">Volver al listado</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.surveys.update', $survey) }}" method="POST" id="surveyForm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="career_id" class="form-label">Carrera <span class="text-danger">*</span></label>
            <select name="career_id" id="career_id" class="form-select" required>
                <option value="">-- Seleccione Carrera --</option>
                @foreach ($careers as $career)
                    <option value="{{ $career->id }}"
                        {{ old('career_id', $survey->career_id) == $career->id ? 'selected' : '' }}>
                        {{ $career->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Título de la Encuesta <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control"
                value="{{ old('title', $survey->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $survey->description) }}</textarea>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="start_date" class="form-label">Fecha de inicio</label>
                <input type="date" name="start_date" id="start_date" class="form-control"
                    value="{{ old('start_date', optional($survey->start_date)->format('Y-m-d')) }}">
            </div>
            <div class="col">
                <label for="end_date" class="form-label">Fecha de fin</label>
                <input type="date" name="end_date" id="end_date" class="form-control"
                    value="{{ old('end_date', optional($survey->end_date)->format('Y-m-d')) }}">
            </div>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                {{ old('is_active', $survey->is_active) ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">Activo</label>
        </div>

        <hr>

        <h3>Preguntas</h3>
        <div id="questionsContainer">
            @foreach ($survey->questions as $i => $question)
                <div class="card mb-3 question-item">
                    <div class="card-body">
                        <button type="button" class="btn-close float-end remove-question-btn"
                            aria-label="Eliminar pregunta"></button>

                        <div class="mb-3">
                            <label class="form-label">Texto de la pregunta <span class="text-danger">*</span></label>
                            <input type="text" name="questions[{{ $i }}][question_text]" class="form-control"
                                required value="{{ old("questions.$i.question_text", $question->question_text) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipo de pregunta <span class="text-danger">*</span></label>
                            <select name="questions[{{ $i }}][type]" class="form-select question-type" required>
                                <option value="">-- Seleccione tipo --</option>
                                <option value="option"
                                    {{ old("questions.$i.type", $question->type) == 'option' ? 'selected' : '' }}>Opción
                                    múltiple</option>
                                <option value="checkbox"
                                    {{ old("questions.$i.type", $question->type) == 'checkbox' ? 'selected' : '' }}>
                                    Selección múltiple</option>
                                <option value="scale"
                                    {{ old("questions.$i.type", $question->type) == 'scale' ? 'selected' : '' }}>Escala
                                    (1-5)</option>
                                <option value="boolean"
                                    {{ old("questions.$i.type", $question->type) == 'boolean' ? 'selected' : '' }}>Sí / No
                                </option>
                            </select>
                        </div>

                        <div class="mb-3 options-container"
                            style="{{ in_array(old("questions.$i.type", $question->type), ['option', 'checkbox']) ? 'display:block;' : 'display:none;' }}">
                            <label class="form-label">Opciones <span class="text-danger">*</span></label>
                            <div class="options-list">
                                @php
                                    $options = old(
                                        "questions.$i.options",
                                        is_array($question->options) ? $question->options : [],
                                    );
                                @endphp
                                @foreach ($options as $opt)
                                    <div class="input-group mb-2">
                                        <input type="text" name="questions[{{ $i }}][options][]"
                                            class="form-control" value="{{ $opt }}" required>
                                        <button type="button" class="btn btn-danger remove-option-btn">Eliminar</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2 add-option-btn">Agregar
                                opción</button>
                        </div>

                        <div class="row scale-container"
                            style="{{ old("questions.$i.type", $question->type) === 'scale' ? 'display:flex;' : 'display:none;' }}">
                            <div class="col">
                                <label class="form-label">Valor mínimo</label>
                                <input type="number" name="questions[{{ $i }}][scale_min]"
                                    class="form-control"
                                    value="{{ old("questions.$i.scale_min", $question->scale_min ?? 1) }}" readonly>
                            </div>
                            <div class="col">
                                <label class="form-label">Valor máximo</label>
                                <input type="number" name="questions[{{ $i }}][scale_max]"
                                    class="form-control"
                                    value="{{ old("questions.$i.scale_max", $question->scale_max ?? 5) }}" readonly>
                            </div>
                        </div>

                        <input type="hidden" name="questions[{{ $i }}][id]" value="{{ $question->id }}">
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-outline-primary mb-3" id="addQuestionBtn">Agregar Pregunta</button>
        <button type="submit" class="btn btn-primary">Actualizar Encuesta</button>
    </form>

    {{-- Template para nuevas preguntas --}}
    <template id="questionTemplate">
        <div class="card mb-3 question-item">
            <div class="card-body">
                <button type="button" class="btn-close float-end remove-question-btn"
                    aria-label="Eliminar pregunta"></button>

                <div class="mb-3">
                    <label class="form-label">Texto de la pregunta <span class="text-danger">*</span></label>
                    <input type="text" name="questions[__INDEX__][question_text]" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo de pregunta <span class="text-danger">*</span></label>
                    <select name="questions[__INDEX__][type]" class="form-select question-type" required>
                        <option value="">-- Seleccione tipo --</option>
                        <option value="option">Opción múltiple</option>
                        <option value="checkbox">Selección múltiple</option>
                        <option value="scale">Escala (1-5)</option>
                        <option value="boolean">Sí / No</option>
                    </select>
                </div>

                <div class="mb-3 options-container" style="display:none;">
                    <label class="form-label">Opciones <span class="text-danger">*</span></label>
                    <div class="options-list"></div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2 add-option-btn">Agregar
                        opción</button>
                </div>

                <div class="row scale-container" style="display:none;">
                    <div class="col">
                        <label class="form-label">Valor mínimo</label>
                        <input type="number" name="questions[__INDEX__][scale_min]" class="form-control" value="1"
                            readonly>
                    </div>
                    <div class="col">
                        <label class="form-label">Valor máximo</label>
                        <input type="number" name="questions[__INDEX__][scale_max]" class="form-control" value="5"
                            readonly>
                    </div>
                </div>
            </div>
        </div>
    </template>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('questionsContainer');
            const template = document.getElementById('questionTemplate');
            const addBtn = document.getElementById('addQuestionBtn');
            const form = document.getElementById('surveyForm');

            // Detectar el índice más alto usado en preguntas existentes
            let lastIndex = -1;
            container.querySelectorAll('.question-item').forEach((card) => {
                const input = card.querySelector('input[name^="questions["]');
                if (input) {
                    const name = input.name; // ejemplo: questions[0][question_text]
                    const match = name.match(/questions\[(\d+)\]/);
                    if (match) {
                        const idx = parseInt(match[1]);
                        if (idx > lastIndex) lastIndex = idx;
                    }
                }
            });

            function attachEventsToCard(card) {
                const typeSelect = card.querySelector('.question-type');
                const optionsContainer = card.querySelector('.options-container');
                const scaleContainer = card.querySelector('.scale-container');
                const optionsList = card.querySelector('.options-list');
                const addOptionBtn = card.querySelector('.add-option-btn');

                function toggleFields() {
                    const type = typeSelect.value;
                    if (type === 'option' || type === 'checkbox') {
                        optionsContainer.style.display = 'block';
                        scaleContainer.style.display = 'none';
                    } else if (type === 'scale') {
                        optionsContainer.style.display = 'none';
                        scaleContainer.style.display = 'flex';
                    } else {
                        optionsContainer.style.display = 'none';
                        scaleContainer.style.display = 'none';
                    }
                }

                typeSelect.addEventListener('change', toggleFields);
                toggleFields();

                addOptionBtn?.addEventListener('click', () => {
                    const questionCard = addOptionBtn.closest('.question-item');
                    const questionTextInput = questionCard.querySelector('input[name^="questions"]');
                    const nameAttr = questionTextInput.getAttribute(
                    'name'); // e.g. questions[0][question_text]
                    const match = nameAttr.match(/questions\[(\d+)\]\[question_text\]/);
                    const questionIndex = match ? match[1] : '';

                    const div = document.createElement('div');
                    div.className = 'input-group mb-2';
                    div.innerHTML = `
                        <input type="text" name="questions[${questionIndex}][options][]" class="form-control" required>
                        <button type="button" class="btn btn-danger remove-option-btn">Eliminar</button>
                    `;
                    optionsList.appendChild(div);

                    div.querySelector('.remove-option-btn').addEventListener('click', () => div.remove());
                });

                card.querySelectorAll('.remove-option-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        btn.closest('.input-group').remove();
                    });
                });

                card.querySelector('.remove-question-btn')?.addEventListener('click', () => {
                    card.remove();
                });
            }

            addBtn.addEventListener('click', () => {
                lastIndex++;
                let html = template.innerHTML.replace(/__INDEX__/g, lastIndex);
                container.insertAdjacentHTML('beforeend', html);

                const newCard = container.querySelector(`.question-item:last-child`);
                attachEventsToCard(newCard);
            });

            // Inicializar eventos en preguntas existentes
            container.querySelectorAll('.question-item').forEach(attachEventsToCard);

            // Validar que haya al menos una pregunta antes de enviar el formulario
            form.addEventListener('submit', function(event) {
                const questionsCount = container.querySelectorAll('.question-item').length;
                if (questionsCount === 0) {
                    event.preventDefault();
                    alert('La encuesta debe tener al menos una pregunta.');
                }
            });
        });
    </script>
@endsection
