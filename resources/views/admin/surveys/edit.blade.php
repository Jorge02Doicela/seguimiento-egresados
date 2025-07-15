@extends('layouts.app')

@section('title', 'Editar Encuesta')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-text-primary mb-6">Editar Encuesta: {{ $survey->title }}</h1>

        <form action="{{ route('admin.surveys.update', $survey) }}" method="POST"
            class="bg-white p-8 rounded-2xl shadow-primary-lg max-w-3xl mx-auto">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-text-secondary text-sm font-medium mb-1">Título <span
                        class="text-error">*</span></label>
                <input type="text" name="title" value="{{ old('title', $survey->title) }}" required class="form-input" />
                @error('title')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-text-secondary text-sm font-medium mb-1">Descripción</label>
                <textarea name="description" class="form-textarea">{{ old('description', $survey->description) }}</textarea>
                @error('description')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-text-secondary text-sm font-medium mb-1">Carrera <span
                        class="text-error">*</span></label>
                <select name="career_id" required class="form-select">
                    <option value="">-- Seleccione --</option>
                    @foreach ($careers as $career)
                        <option value="{{ $career->id }}" @selected(old('career_id', $survey->career_id) == $career->id)>{{ $career->name }}</option>
                    @endforeach
                </select>
                @error('career_id')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5 flex items-center">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $survey->is_active)) class="form-checkbox"
                    id="is_active_checkbox" />
                <label for="is_active_checkbox" class="ml-2 text-text-secondary text-sm">Activa</label>
            </div>

            <div class="mb-5">
                <label class="block text-text-secondary text-sm font-medium mb-1">Fecha Inicio</label>
                <input type="date" name="start_date"
                    value="{{ old('start_date', $survey->start_date ? $survey->start_date->format('Y-m-d') : '') }}"
                    class="form-input" />
                @error('start_date')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-text-secondary text-sm font-medium mb-1">Fecha Fin</label>
                <input type="date" name="end_date"
                    value="{{ old('end_date', $survey->end_date ? $survey->end_date->format('Y-m-d') : '') }}"
                    class="form-input" />
                @error('end_date')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <hr class="border-t border-gray-lighter my-8" />
            <h2 class="text-2xl font-bold text-text-primary mb-4">Preguntas</h2>

            <div id="questions-container" class="space-y-6"></div>

            <button type="button" onclick="addQuestion()"
                class="btn btn-secondary px-6 py-3 mb-6 shadow-secondary hover:shadow-secondary-dark">+ Añadir
                pregunta</button>

            <button type="submit" class="btn btn-primary px-6 py-3 shadow-primary hover:shadow-primary-dark">Actualizar
                Encuesta</button>
            <a href="{{ route('admin.surveys.index') }}"
                class="btn bg-gray-silver text-white hover:bg-gray-slate focus:ring-gray-silver px-6 py-3 ml-3">Cancelar</a>
        </form>
    </div>

    @php
        $questionsData = old(
            'questions',
            $survey->questions
                ->map(function ($q) {
                    return [
                        'id' => $q->id,
                        'text' => $q->question_text,
                        'type' => $q->type,
                        'options' => $q->options ? json_decode($q->options) : [],
                        'scale_min' => $q->scale_min,
                        'scale_max' => $q->scale_max,
                    ];
                })
                ->toArray(),
        );
    @endphp

    <script>
        let questionCount = 0;
        const questions = @json($questionsData);

        function addQuestion(data = null) {
            const container = document.getElementById('questions-container');
            const div = document.createElement('div');
            div.classList.add('bg-bg-secondary', 'p-6', 'rounded-lg', 'shadow-sm', 'border', 'border-gray-lighter');

            let optionsText = '';
            if (data && (data.type === 'option' || data.type === 'checkbox')) {
                if (Array.isArray(data.options)) {
                    optionsText = data.options.join(', ');
                } else if (typeof data.options === 'string') {
                    optionsText = data.options;
                }
            }

            let optionsHTML = (data && (data.type === 'option' || data.type === 'checkbox')) ? `
                <div class="mb-4">
                    <label class="block text-text-secondary text-sm font-medium mb-1">Opciones (separadas por coma)</label>
                    <textarea name="questions[${questionCount}][options]" class="form-textarea">${optionsText}</textarea>
                </div>
            ` : '';

            let scaleHTML = (data && data.type === 'scale') ? `
                <div class="mb-4 flex gap-4">
                    <div class="w-1/2">
                        <label class="block text-text-secondary text-sm font-medium mb-1">Escala mínima</label>
                        <input type="number" name="questions[${questionCount}][scale_min]" value="${data.scale_min || 1}" class="form-input" />
                    </div>
                    <div class="w-1/2">
                        <label class="block text-text-secondary text-sm font-medium mb-1">Escala máxima</label>
                        <input type="number" name="questions[${questionCount}][scale_max]" value="${data.scale_max || 5}" class="form-input" />
                    </div>
                </div>
            ` : '';

            div.innerHTML = `
                <input type="hidden" name="questions[${questionCount}][id]" value="${data?.id ?? ''}">
                <div class="mb-4">
                    <label class="block text-text-secondary text-sm font-medium mb-1">Texto de la pregunta <span class="text-error">*</span></label>
                    <input type="text" name="questions[${questionCount}][text]" value="${data?.text ?? ''}" required class="form-input" />
                </div>

                <div class="mb-4">
                    <label class="block text-text-secondary text-sm font-medium mb-1">Tipo de pregunta <span class="text-error">*</span></label>
                    <select name="questions[${questionCount}][type]" onchange="toggleFields(this, ${questionCount})" required class="form-select">
                        <option value="checkbox" ${data?.type === 'checkbox' ? 'selected' : ''}>Selección múltiple</option>
                        <option value="scale" ${data?.type === 'scale' ? 'selected' : ''}>Escala (1-5)</option>
                        <option value="boolean" ${data?.type === 'boolean' ? 'selected' : ''}>Sí / No</option>
                    </select>
                </div>

                <div id="options-${questionCount}" class="mb-2" style="display:none;">
                    ${optionsHTML}
                </div>

                <div id="scale-${questionCount}" class="mb-2" style="display:none;">
                    ${scaleHTML}
                </div>

                <button type="button" onclick="this.closest('.bg-bg-secondary').remove()" class="btn bg-error text-white hover:bg-error-dark focus:ring-error mt-4">Eliminar Pregunta</button>
            `;

            container.appendChild(div);

            toggleFields(div.querySelector('select'), questionCount);

            questionCount++;
        }

        // Cargar preguntas existentes
        questions.forEach(q => addQuestion(q));

        function toggleFields(select, id) {
            document.getElementById(`options-${id}`).style.display = (select.value === 'checkbox') ? 'block' : 'none';

            // Re-render scaleHTML if type changes from non-scale to scale
            const scaleDiv = document.getElementById(`scale-${id}`);
            if (select.value === 'scale' && scaleDiv.innerHTML.trim() === '') {
                scaleDiv.innerHTML = `
                    <div class="mb-4 flex gap-4">
                        <div class="w-1/2">
                            <label class="block text-text-secondary text-sm font-medium mb-1">Escala mínima</label>
                            <input type="number" name="questions[${id}][scale_min]" value="${(questions[id] && questions[id].scale_min) ? questions[id].scale_min : 1}" class="form-input" />
                        </div>
                        <div class="w-1/2">
                            <label class="block text-text-secondary text-sm font-medium mb-1">Escala máxima</label>
                            <input type="number" name="questions[${id}][scale_max]" value="${(questions[id] && questions[id].scale_max) ? questions[id].scale_max : 5}" class="form-input" />
                        </div>
                    </div>
                `;
            }
            scaleDiv.style.display = select.value === 'scale' ? 'block' : 'none';
        }
    </script>
@endsection
