@extends('layouts.admin')

@section('title', 'Crear Nueva Encuesta')

@section('content')
    <h1>Crear Nueva Encuesta</h1>

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

    <form action="{{ route('admin.surveys.store') }}" method="POST" id="surveyForm">
        @csrf

        <div class="mb-3">
            <label for="career_id" class="form-label">Carrera <span class="text-danger">*</span></label>
            <select name="career_id" id="career_id" class="form-select" required>
                <option value="">-- Seleccione Carrera --</option>
                @foreach ($careers as $career)
                    <option value="{{ $career->id }}" {{ old('career_id') == $career->id ? 'selected' : '' }}>
                        {{ $career->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Título de la Encuesta <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="start_date" class="form-label">Fecha de inicio</label>
                <input type="date" name="start_date" id="start_date" class="form-control"
                    value="{{ old('start_date') }}">
            </div>
            <div class="col">
                <label for="end_date" class="form-label">Fecha de fin</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}">
            </div>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                {{ old('is_active') ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">
                Activa
            </label>
        </div>

        <hr>

        <h3>Preguntas</h3>

        <div id="questionsContainer">
            {{-- Preguntas agregadas dinámicamente --}}
        </div>

        <button type="button" class="btn btn-outline-primary mb-3" id="addQuestionBtn">Agregar Pregunta</button>

        <button type="submit" class="btn btn-success">Guardar Encuesta</button>
    </form>

    {{-- Plantilla de pregunta oculta para clonar --}}
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
            const questionsContainer = document.getElementById('questionsContainer');
            const addQuestionBtn = document.getElementById('addQuestionBtn');
            const questionTemplate = document.getElementById('questionTemplate').content;

            let questionIndex = 0;

            function createOptionInput(qIndex, value = '') {
                const div = document.createElement('div');
                div.classList.add('input-group', 'mb-2');

                const input = document.createElement('input');
                input.type = 'text';
                input.name = `questions[${qIndex}][options][]`;
                input.className = 'form-control';
                input.value = value;
                input.required = true;

                const btnRemove = document.createElement('button');
                btnRemove.type = 'button';
                btnRemove.className = 'btn btn-danger';
                btnRemove.textContent = 'Eliminar';

                btnRemove.addEventListener('click', () => div.remove());

                div.appendChild(input);
                div.appendChild(btnRemove);

                return div;
            }

            function toggleOptionsAndScale(questionCard, qIndex) {
                const typeSelect = questionCard.querySelector('.question-type');
                const optionsContainer = questionCard.querySelector('.options-container');
                const scaleContainer = questionCard.querySelector('.scale-container');
                const optionsList = questionCard.querySelector('.options-list');

                function setRequiredForOptions(required) {
                    optionsList.querySelectorAll('input').forEach(input => input.required = required);
                }

                const addOptionBtn = questionCard.querySelector('.add-option-btn');
                addOptionBtn.addEventListener('click', () => {
                    const optionInput = createOptionInput(qIndex);
                    optionsList.appendChild(optionInput);
                });

                typeSelect.addEventListener('change', () => {
                    const val = typeSelect.value;
                    if (val === 'option' || val === 'checkbox') {
                        optionsContainer.style.display = 'block';
                        scaleContainer.style.display = 'none';
                        setRequiredForOptions(true);
                        if (optionsList.children.length === 0) {
                            addOptionBtn.click();
                        }
                    } else if (val === 'scale') {
                        optionsContainer.style.display = 'none';
                        scaleContainer.style.display = 'flex';
                        setRequiredForOptions(false);
                    } else {
                        optionsContainer.style.display = 'none';
                        scaleContainer.style.display = 'none';
                        setRequiredForOptions(false);
                    }
                });

                typeSelect.dispatchEvent(new Event('change'));
            }

            function addQuestion() {
                const clone = document.importNode(questionTemplate, true);
                const questionCard = clone.querySelector('.question-item');

                questionCard.querySelector('.question-text').name = `questions[${questionIndex}][question_text]`;
                questionCard.querySelector('.question-type').name = `questions[${questionIndex}][type]`;
                questionCard.querySelector('.question-scale-min').name = `questions[${questionIndex}][scale_min]`;
                questionCard.querySelector('.question-scale-max').name = `questions[${questionIndex}][scale_max]`;

                questionsContainer.appendChild(clone);
                const addedCard = questionsContainer.lastElementChild;

                toggleOptionsAndScale(addedCard, questionIndex);

                addedCard.querySelector('.remove-question-btn').addEventListener('click', () => addedCard.remove());

                questionIndex++;
            }

            addQuestionBtn.addEventListener('click', addQuestion);

            if (questionsContainer.children.length === 0) {
                addQuestion();
            }
        });
    </script>
@endsection
