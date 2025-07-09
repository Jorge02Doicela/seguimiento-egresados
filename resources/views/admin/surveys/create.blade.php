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
            <label class="form-check-label" for="is_active">Activa</label>
        </div>

        <hr>

        <h3>Preguntas</h3>

        <div id="questionsContainer">
            {{-- Aquí se agregarán preguntas dinámicamente --}}
        </div>

        <button type="button" class="btn btn-outline-primary mb-3" id="addQuestionBtn">Agregar Pregunta</button>

        <button type="submit" class="btn btn-success">Guardar Encuesta</button>

        <pre id="formDebug" style="background:#eee; padding:10px; max-height:300px; overflow:auto; white-space: pre-wrap;"></pre>
    </form>

    {{-- Plantilla de pregunta oculta para clonar --}}
    <template id="questionTemplate">
        <div class="card mb-3 question-item">
            <div class="card-body">
                <button type="button" class="btn-close float-end remove-question-btn"
                    aria-label="Eliminar pregunta"></button>

                <div class="mb-3">
                    <label class="form-label">Texto de la pregunta <span class="text-danger">*</span></label>
                    <input type="text" name="questions[__INDEX__][question_text]" class="form-control question-text"
                        required>
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
                        <input type="number" name="questions[__INDEX__][scale_min]"
                            class="form-control question-scale-min" value="1" readonly>
                    </div>
                    <div class="col">
                        <label class="form-label">Valor máximo</label>
                        <input type="number" name="questions[__INDEX__][scale_max]"
                            class="form-control question-scale-max" value="5" readonly>
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
            const questionTemplate = document.getElementById('questionTemplate').innerHTML;

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

            function addQuestion() {
                let html = questionTemplate.replace(/__INDEX__/g, questionIndex);
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html.trim();

                // Cambiado a querySelector para evitar que firstChild sea un nodo texto
                const questionCard = tempDiv.querySelector('.question-item');
                questionsContainer.appendChild(questionCard);

                const addOptionBtn = questionCard.querySelector('.add-option-btn');
                const optionsList = questionCard.querySelector('.options-list');
                const typeSelect = questionCard.querySelector('.question-type');

                addOptionBtn.addEventListener('click', () => {
                    const optionInput = createOptionInput(questionIndex);
                    optionsList.appendChild(optionInput);
                });

                // Mostrar/ocultar opciones o escala según tipo
                typeSelect.addEventListener('change', () => {
                    const val = typeSelect.value;
                    const optionsContainer = questionCard.querySelector('.options-container');
                    const scaleContainer = questionCard.querySelector('.scale-container');

                    if (val === 'option' || val === 'checkbox') {
                        optionsContainer.style.display = 'block';
                        scaleContainer.style.display = 'none';

                        optionsList.querySelectorAll('input').forEach(i => i.required = true);

                        if (optionsList.children.length === 0) {
                            addOptionBtn.click();
                        }
                    } else if (val === 'scale') {
                        optionsContainer.style.display = 'none';
                        scaleContainer.style.display = 'flex';

                        optionsList.querySelectorAll('input').forEach(i => i.required = false);
                    } else {
                        optionsContainer.style.display = 'none';
                        scaleContainer.style.display = 'none';

                        optionsList.querySelectorAll('input').forEach(i => i.required = false);
                    }
                });

                typeSelect.dispatchEvent(new Event('change'));

                questionCard.querySelector('.remove-question-btn').addEventListener('click', () => {
                    questionCard.remove();
                });

                questionIndex++;
            }

            addQuestionBtn.addEventListener('click', addQuestion);

            if (questionsContainer.children.length === 0) {
                addQuestion();
            }

            // Validación personalizada antes de enviar
            const surveyForm = document.getElementById('surveyForm');

            surveyForm.addEventListener('submit', function(e) {
                // Limpiar errores previos
                const questionItems = surveyForm.querySelectorAll('.question-item');
                questionItems.forEach(item => {
                    item.querySelectorAll('.form-control, .form-select').forEach(input => {
                        input.classList.remove('is-invalid');
                    });
                });

                let isValid = true;

                questionItems.forEach((questionCard, index) => {
                    const questionText = questionCard.querySelector(
                        'input[name^="questions"][name$="[question_text]"]');
                    const questionType = questionCard.querySelector(
                        'select[name^="questions"][name$="[type]"]');

                    if (!questionText.value.trim()) {
                        questionText.classList.add('is-invalid');
                        isValid = false;
                    }
                    if (!questionType.value) {
                        questionType.classList.add('is-invalid');
                        isValid = false;
                    }

                    // Si tipo es opción múltiple o checkbox, validar que tenga al menos una opción no vacía
                    if (['option', 'checkbox'].includes(questionType.value)) {
                        const optionInputs = questionCard.querySelectorAll('.options-list input');
                        let hasValidOption = false;
                        optionInputs.forEach(optInput => {
                            if (optInput.value.trim()) {
                                hasValidOption = true;
                                optInput.classList.remove('is-invalid');
                            } else {
                                optInput.classList.add('is-invalid');
                            }
                        });
                        if (!hasValidOption) {
                            isValid = false;
                        }
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert(
                        'Por favor completa todos los campos requeridos en las preguntas antes de guardar.');
                }
            });
        });
    </script>
@endsection
