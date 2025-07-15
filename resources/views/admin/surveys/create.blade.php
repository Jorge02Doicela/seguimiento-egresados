@extends('layouts.app')

@section('title', 'Crear Encuesta')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-text-primary mb-6">Crear Nueva Encuesta</h1>

        @if ($errors->any())
            <div class="bg-error-lighter text-error px-4 py-3 rounded-lg mb-6 shadow-sm" role="alert">
                <ul class="mb-0 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-error-lighter text-error px-4 py-3 rounded-lg mb-6 shadow-sm" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.surveys.store') }}" method="POST"
            class="bg-white p-8 rounded-2xl shadow-primary-lg max-w-3xl mx-auto">
            @csrf

            <div class="mb-5">
                <label class="block text-text-secondary text-sm font-medium mb-1">Título <span
                        class="text-error">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required class="form-input" />
                @error('title')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-text-secondary text-sm font-medium mb-1">Descripción</label>
                <textarea name="description" class="form-textarea">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="career_id" class="block text-text-secondary text-sm font-medium mb-1">Carrera</label>
                <select name="career_id" id="career_id" required class="form-select">
                    <option value="">-- Seleccione --</option>
                    @foreach ($careers as $career)
                        @if ($career->name !== 'General')
                            <option value="{{ $career->id }}" {{ old('career_id') == $career->id ? 'selected' : '' }}>
                                {{ $career->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('career_id')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5 flex items-center">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active')) class="form-checkbox"
                    id="is_active_checkbox" />
                <label for="is_active_checkbox" class="ml-2 text-text-secondary text-sm">Activa</label>
            </div>

            <div class="mb-5">
                <label class="block text-text-secondary text-sm font-medium mb-1">Fecha Inicio</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" class="form-input" />
                @error('start_date')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-text-secondary text-sm font-medium mb-1">Fecha Fin</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-input" />
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

            <button type="submit" class="btn btn-primary px-6 py-3 shadow-primary hover:shadow-primary-dark">Guardar
                Encuesta</button>
            <a href="{{ route('admin.surveys.index') }}"
                class="btn bg-gray-silver text-white hover:bg-gray-slate focus:ring-gray-silver px-6 py-3 ml-3">Cancelar</a>
        </form>
    </div>

    <script>
        let questionCount = 0;

        function addQuestion() {
            const container = document.getElementById('questions-container');
            const div = document.createElement('div');
            div.classList.add('bg-bg-secondary', 'p-6', 'rounded-lg', 'shadow-sm', 'border', 'border-gray-lighter');
            div.innerHTML = `
                <div class="mb-4">
                    <label class="block text-text-secondary text-sm font-medium mb-1">Texto de la pregunta <span class="text-error">*</span></label>
                    <input type="text" name="questions[${questionCount}][text]" required class="form-input" />
                </div>

                <div class="mb-4">
                    <label class="block text-text-secondary text-sm font-medium mb-1">Tipo de pregunta <span class="text-error">*</span></label>
                    <select name="questions[${questionCount}][type]" onchange="toggleFields(this, ${questionCount})" required class="form-select">
                        <option value="checkbox" selected>Selección múltiple</option>
                        <option value="scale">Escala (1-5)</option>
                        <option value="boolean">Sí / No</option>
                    </select>
                </div>

                <div id="options-${questionCount}" class="mb-2" style="display:none;">
                    <label class="block text-text-secondary text-sm font-medium mb-1">Opciones (separadas por coma)</label>
                    <textarea name="questions[${questionCount}][options]" class="form-textarea"></textarea>
                </div>

                <div id="scale-${questionCount}" class="mb-2" style="display:none;">
                    <div class="mb-4 flex gap-4">
                        <div class="w-1/2">
                            <label class="block text-text-secondary text-sm font-medium mb-1">Escala mínima</label>
                            <input type="number" name="questions[${questionCount}][scale_min]" value="1" class="form-input" />
                        </div>
                        <div class="w-1/2">
                            <label class="block text-text-secondary text-sm font-medium mb-1">Escala máxima</label>
                            <input type="number" name="questions[${questionCount}][scale_max]" value="5" class="form-input" />
                        </div>
                    </div>
                </div>

                <button type="button" onclick="this.closest('.bg-bg-secondary').remove()" class="btn bg-error text-white hover:bg-error-dark focus:ring-error mt-4">Eliminar Pregunta</button>
            `;
            container.appendChild(div);

            // Forzar mostrar campos correctos según tipo por defecto
            const selectElement = div.querySelector('select');
            toggleFields(selectElement, questionCount);

            questionCount++;
        }

        function toggleFields(select, id) {
            document.getElementById(`options-${id}`).style.display = (select.value === 'checkbox') ? 'block' : 'none';
            document.getElementById(`scale-${id}`).style.display = (select.value === 'scale') ? 'block' : 'none';
        }
    </script>
@endsection
