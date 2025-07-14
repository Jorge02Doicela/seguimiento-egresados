@extends('layouts.admin')

@section('title', 'Editar Encuesta')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Editar Encuesta: {{ $survey->title }}</h1>

    <form action="{{ route('admin.surveys.update', $survey) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Título <span class="text-red-600">*</span></label>
            <input type="text" name="title" value="{{ old('title', $survey->title) }}" required class="input" />
            @error('title')
                <p class="text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Descripción</label>
            <textarea name="description" class="input">{{ old('description', $survey->description) }}</textarea>
            @error('description')
                <p class="text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Carrera <span class="text-red-600">*</span></label>
            <select name="career_id" required class="input">
                <option value="">-- Seleccione --</option>
                @foreach ($careers as $career)
                    <option value="{{ $career->id }}" @selected(old('career_id', $survey->career_id) == $career->id)>{{ $career->name }}</option>
                @endforeach
            </select>
            @error('career_id')
                <p class="text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $survey->is_active)) /> Activa</label>
        </div>

        <div>
            <label>Fecha Inicio</label>
            <input type="date" name="start_date"
                value="{{ old('start_date', $survey->start_date ? $survey->start_date->format('Y-m-d') : '') }}"
                class="input" />
            @error('start_date')
                <p class="text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Fecha Fin</label>
            <input type="date" name="end_date"
                value="{{ old('end_date', $survey->end_date ? $survey->end_date->format('Y-m-d') : '') }}"
                class="input" />
            @error('end_date')
                <p class="text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <hr class="my-4" />
        <h2 class="font-semibold mb-2">Preguntas</h2>

        <div id="questions-container"></div>

        <button type="button" onclick="addQuestion()" class="btn btn-secondary mb-4">+ Añadir pregunta</button>

        <button type="submit" class="btn btn-primary">Actualizar Encuesta</button>
    </form>

    <script>
        let questionCount = 0;
        const questions = @json(old(
                'questions',
                $survey->questions->map(function ($q) {
                    return [
                        'id' => $q->id,
                        'text' => $q->question_text,
                        'type' => $q->type,
                        'options' => $q->options ? implode(',', json_decode($q->options)) : '',
                        'scale_min' => $q->scale_min,
                        'scale_max' => $q->scale_max,
                    ];
                })));

        function addQuestion(data = null) {
            const container = document.getElementById('questions-container');
            const div = document.createElement('div');
            div.classList.add('mb-4', 'border', 'p-4', 'rounded', 'bg-gray-50');

            let optionsHTML = '';
            let scaleHTML = '';

            if (data) {
                optionsHTML = (data.type === 'option' || data.type === 'checkbox') ? `
            <label>Opciones (separadas por coma)</label>
            <textarea name="questions[${questionCount}][options]" class="input">${data.options}</textarea>
        ` : '';

                scaleHTML = (data.type === 'scale') ? `
            <label>Escala mínima</label>
            <input type="number" name="questions[${questionCount}][scale_min]" value="${data.scale_min || 1}" class="input" />
            <label>Escala máxima</label>
            <input type="number" name="questions[${questionCount}][scale_max]" value="${data.scale_max || 5}" class="input" />
        ` : '';
            }

            div.innerHTML = `
        <input type="hidden" name="questions[${questionCount}][id]" value="${data?.id ?? ''}">
        <label>Texto de la pregunta <span class="text-red-600">*</span></label>
        <input type="text" name="questions[${questionCount}][text]" value="${data?.text ?? ''}" required class="input mb-2" />

        <label>Tipo de pregunta <span class="text-red-600">*</span></label>
        <select name="questions[${questionCount}][type]" onchange="toggleFields(this, ${questionCount})" required class="input mb-2">
            <option value="option" ${data?.type === 'option' ? 'selected' : ''}>Opción única</option>
            <option value="checkbox" ${data?.type === 'checkbox' ? 'selected' : ''}>Selección múltiple</option>
            <option value="scale" ${data?.type === 'scale' ? 'selected' : ''}>Escala (1-5)</option>
            <option value="boolean" ${data?.type === 'boolean' ? 'selected' : ''}>Sí / No</option>
        </select>

        <div id="options-${questionCount}" class="mb-2" style="display:none;">
            ${optionsHTML}
        </div>

        <div id="scale-${questionCount}" class="mb-2" style="display:none;">
            ${scaleHTML}
        </div>

        <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger mt-2">Eliminar Pregunta</button>
    `;
            container.appendChild(div);

            toggleFields(div.querySelector('select'), questionCount);
            questionCount++;
        }

        // Cargar preguntas existentes
        questions.forEach(q => addQuestion(q));

        function toggleFields(select, id) {
            document.getElementById(`options-${id}`).style.display = (select.value === 'option' || select.value ===
                'checkbox') ? 'block' : 'none';
            document.getElementById(`scale-${id}`).style.display = select.value === 'scale' ? 'block' : 'none';
        }
    </script>
@endsection
