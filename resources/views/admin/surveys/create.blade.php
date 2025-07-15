@extends('layouts.app')

@section('title', 'Crear Encuesta')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Crear Nueva Encuesta</h1>
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.surveys.store') }}" method="POST">
        @csrf

        <div>
            <label>Título <span class="text-red-600">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" required class="input" />
        </div>

        <div>
            <label>Descripción</label>
            <textarea name="description" class="input">{{ old('description') }}</textarea>
        </div>

        <div>
            <label for="career_id" class="block mb-2 font-semibold">Carrera</label>
            <select name="career_id" id="career_id" required class="w-full border border-gray-300 rounded px-3 py-2">
                @foreach ($careers as $career)
                    @if ($career->name !== 'General')
                        <option value="{{ $career->id }}" {{ old('career_id') == $career->id ? 'selected' : '' }}>
                            {{ $career->name }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div>
            <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active')) /> Activa</label>
        </div>

        <div>
            <label>Fecha Inicio</label>
            <input type="date" name="start_date" value="{{ old('start_date') }}" class="input" />
        </div>

        <div>
            <label>Fecha Fin</label>
            <input type="date" name="end_date" value="{{ old('end_date') }}" class="input" />
        </div>

        <hr class="my-4" />
        <h2 class="font-semibold mb-2">Preguntas</h2>

        <div id="questions-container"></div>

        <button type="button" onclick="addQuestion()" class="btn btn-secondary mb-4">+ Añadir pregunta</button>

        <button type="submit" class="btn btn-primary">Guardar Encuesta</button>
    </form>

    <script>
        let questionCount = 0;

        function addQuestion() {
            const container = document.getElementById('questions-container');
            const div = document.createElement('div');
            div.classList.add('mb-4', 'border', 'p-4', 'rounded', 'bg-gray-50');
            div.innerHTML = `
                <label>Texto de la pregunta <span class="text-red-600">*</span></label>
                <input type="text" name="questions[${questionCount}][text]" required class="input mb-2" />

                <label>Tipo de pregunta <span class="text-red-600">*</span></label>
                <select name="questions[${questionCount}][type]" onchange="toggleFields(this, ${questionCount})" required class="input mb-2">
                    <option value="checkbox" selected>Selección múltiple</option>
                    <option value="scale">Escala (1-5)</option>
                    <option value="boolean">Sí / No</option>
                </select>

                <div id="options-${questionCount}" class="mb-2" style="display:none;">
                    <label>Opciones (separadas por coma)</label>
                    <textarea name="questions[${questionCount}][options]" class="input"></textarea>
                </div>

                <div id="scale-${questionCount}" class="mb-2" style="display:none;">
                    <label>Escala mínima</label>
                    <input type="number" name="questions[${questionCount}][scale_min]" value="1" class="input" />
                    <label>Escala máxima</label>
                    <input type="number" name="questions[${questionCount}][scale_max]" value="5" class="input" />
                </div>

                <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger mt-2">Eliminar Pregunta</button>
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
