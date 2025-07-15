@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 md:p-8">
        <h1 class="text-4xl font-headings text-text-primary mb-6">Editar Perfil</h1>

        @if ($errors->any())
            <div class="bg-error-lighter text-error px-4 py-3 rounded-lg mb-6 text-sm" role="alert">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-2xl p-6 mb-8">
            <form action="{{ route('graduate.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-5">
                    <label class="block text-sm font-medium text-text-secondary mb-2">¿Está trabajando actualmente?</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input class="form-radio h-4 w-4 text-primary focus:ring-primary border-gray-300" type="radio"
                                name="is_working" id="working_yes" value="1"
                                {{ old('is_working', $graduate->is_working) ? 'checked' : '' }}>
                            <label class="ml-2 text-text-primary" for="working_yes">Sí</label>
                        </div>
                        <div class="flex items-center">
                            <input class="form-radio h-4 w-4 text-primary focus:ring-primary border-gray-300" type="radio"
                                name="is_working" id="working_no" value="0"
                                {{ old('is_working', $graduate->is_working) ? '' : 'checked' }}>
                            <label class="ml-2 text-text-primary" for="working_no">No</label>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <label for="cohort_year" class="block text-sm font-medium text-text-secondary mb-2">Año de cohorte de
                        egreso</label>
                    <input type="number" name="cohort_year" id="cohort_year" class="form-input"
                        value="{{ old('cohort_year', $graduate->cohort_year) }}" required>
                </div>

                <div class="mb-5">
                    <label for="gender" class="block text-sm font-medium text-text-secondary mb-2">Género</label>
                    <select name="gender" id="gender" class="form-select" required>
                        <option value="M" @selected(old('gender', $graduate->gender) == 'M')>Masculino</option>
                        <option value="F" @selected(old('gender', $graduate->gender) == 'F')>Femenino</option>
                        <option value="Otro" @selected(old('gender', $graduate->gender) == 'Otro')>Otro</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label for="career_id" class="block text-sm font-medium text-text-secondary mb-2">Carrera</label>
                    <select name="career_id" id="career_id" class="form-select">
                        <option value="">Seleccione una carrera</option>
                        @foreach ($careers as $career)
                            <option value="{{ $career->id }}"
                                {{ old('career_id', $graduate->career_id) == $career->id ? 'selected' : '' }}>
                                {{ $career->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="workFields"
                    class="border-t border-border-primary pt-5 mt-5 {{ old('is_working', $graduate->is_working) ? '' : 'hidden' }}">
                    <h3 class="text-2xl font-headings text-text-primary mb-4">Detalles Laborales</h3>
                    <div class="mb-5">
                        <label for="company" class="block text-sm font-medium text-text-secondary mb-2">Empresa</label>
                        <input type="text" name="company" id="company" class="form-input"
                            value="{{ old('company', $graduate->company) }}">
                    </div>

                    {{-- Área laboral / Tecnología --}}
                    <div class="mb-5">
                        <label for="tech_position" class="block text-sm font-medium text-text-secondary mb-2">Área laboral /
                            Tecnología</label>
                        <select name="tech_position" id="tech_position" class="form-select" required>
                            <option value="">Seleccione un puesto tecnológico</option>
                            <option value="Desarrollador Web" @selected(old('position', $graduate->position) === 'Desarrollador Web')>Desarrollador Web</option>
                            <option value="Analista de Datos" @selected(old('position', $graduate->position) === 'Analista de Datos')>Analista de Datos</option>
                            <option value="Administrador de Sistemas" @selected(old('position', $graduate->position) === 'Administrador de Sistemas')>Administrador de Sistemas
                            </option>
                            <option value="QA Tester" @selected(old('position', $graduate->position) === 'QA Tester')>QA Tester</option>
                            <option value="otro" @selected(!in_array(old('position', $graduate->position), ['Desarrollador Web', 'Analista de Datos', 'Administrador de Sistemas', 'QA Tester']))>Otro (No tecnológico)</option>
                        </select>
                    </div>

                    {{-- Área laboral no tecnológica (condicional) --}}
                    <div id="non_tech_container" class="mb-5 hidden">
                        <label for="non_tech_position" class="block text-sm font-medium text-text-secondary mb-2">Área
                            laboral no tecnológica</label>
                        <select name="non_tech_position" id="non_tech_position" class="form-select">
                            <option value="">Seleccione un puesto</option>
                            <option value="Vendedor" @selected(old('position', $graduate->position) === 'Vendedor')>Vendedor</option>
                            <option value="Albañil" @selected(old('position', $graduate->position) === 'Albañil')>Albañil</option>
                            <option value="Chofer" @selected(old('position', $graduate->position) === 'Chofer')>Chofer</option>
                            <option value="Mesero" @selected(old('position', $graduate->position) === 'Mesero')>Mesero</option>
                        </select>
                    </div>

                    {{-- Campo oculto donde se guarda el valor final --}}
                    <input type="hidden" name="position" id="final_position"
                        value="{{ old('position', $graduate->position) }}">

                    <div class="mb-5">
                        <label for="salary" class="block text-sm font-medium text-text-secondary mb-2">Salario $</label>
                        <input type="number" step="0.01" name="salary" id="salary" class="form-input"
                            value="{{ old('salary', $graduate->salary) }}">
                    </div>
                </div>

                <div class="border-t border-border-primary pt-5 mt-5">
                    <h3 class="text-2xl font-headings text-text-primary mb-4">Contacto y Documentos</h3>
                    <div class="mb-5">
                        <label for="portfolio_url" class="block text-sm font-medium text-text-secondary mb-2">URL
                            Portafolio</label>
                        <input type="url" name="portfolio_url" id="portfolio_url" class="form-input"
                            value="{{ old('portfolio_url', $graduate->portfolio_url) }}">
                    </div>

                    <div class="mb-5">
                        <label for="cv" class="block text-sm font-medium text-text-secondary mb-2">Subir CV (PDF,
                            DOC, DOCX)</label>
                        <input type="file" name="cv" id="cv"
                            class="block w-full text-sm text-text-secondary
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-primary file:text-white
                        hover:file:bg-primary-dark cursor-pointer mb-2">
                        @if ($graduate->cv_path)
                            <small class="text-text-muted">Archivo actual: <a
                                    href="{{ asset('storage/' . $graduate->cv_path) }}" target="_blank"
                                    class="text-primary hover:text-primary-dark">Ver CV</a></small>
                        @endif
                    </div>

                    <div class="mb-5">
                        <label for="city" class="block text-sm font-medium text-text-secondary mb-2">Ciudad</label>
                        <input type="text" name="city" id="city" class="form-input"
                            value="{{ old('city', $graduate->city) }}">
                    </div>
                </div>

                <button type="submit"
                    class="btn bg-success text-white hover:bg-green-700 focus:ring-green-500 mt-6">Actualizar
                    Perfil</button>
            </form>
        </div>

        ---

        <div class="bg-white shadow-md rounded-2xl p-6 mb-8">
            <h3 class="text-2xl font-headings text-text-primary mb-4 border-b border-border-primary pb-2">Habilidades</h3>
            <ul class="mb-4 space-y-2">
                @forelse ($graduate->skills as $skill)
                    <li
                        class="flex items-center justify-between text-lg text-text-secondary bg-gray-lightest p-3 rounded-lg">
                        <span>{{ $skill->name }}</span>
                        <form action="{{ route('graduate.profile.skills.remove') }}" method="POST"
                            class="inline-block ml-4">
                            @csrf
                            <input type="hidden" name="skill_id" value="{{ $skill->id }}">
                            <button class="btn bg-error text-white hover:bg-error-dark focus:ring-error text-xs px-3 py-1"
                                type="submit">Eliminar</button>
                        </form>
                    </li>
                @empty
                    <li class="text-text-muted">No se han registrado habilidades.</li>
                @endforelse
            </ul>

            <h4 class="text-xl font-headings text-text-primary mb-3">Agregar Nueva Habilidad</h4>
            <form action="{{ route('graduate.profile.skills.add') }}" method="POST"
                class="flex flex-col sm:flex-row items-start sm:items-end gap-3">
                @csrf
                <div class="flex-grow w-full sm:w-auto">
                    <label for="add_skill_id" class="sr-only">Selecciona una habilidad para agregar</label>
                    <select name="skill_id" id="add_skill_id" class="form-select w-full" required>
                        <option value="">Selecciona una habilidad para agregar</option>
                        @foreach ($allSkills as $skill)
                            @if (!$graduate->skills->contains($skill->id))
                                <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary w-full sm:w-auto" type="submit">Agregar Habilidad</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const techSelect = document.getElementById('tech_position');
            const nonTechContainer = document.getElementById('non_tech_container');
            const nonTechSelect = document.getElementById('non_tech_position');
            const finalPosition = document.getElementById('final_position');

            const workFields = document.getElementById('workFields');
            const workingYes = document.getElementById('working_yes');
            const workingNo = document.getElementById('working_no');

            function updateFinalPosition() {
                if (techSelect.value === 'otro') {
                    nonTechContainer.classList.remove('hidden');
                    finalPosition.value = nonTechSelect.value || '';
                } else {
                    nonTechContainer.classList.add('hidden');
                    nonTechSelect.value = '';
                    finalPosition.value = techSelect.value;
                }
            }

            function toggleWorkFields() {
                if (workingYes.checked) {
                    workFields.classList.remove('hidden');
                } else {
                    workFields.classList.add('hidden');
                }
            }

            // Listeners
            techSelect.addEventListener('change', updateFinalPosition);
            nonTechSelect.addEventListener('change', () => {
                if (techSelect.value === 'otro') {
                    finalPosition.value = nonTechSelect.value;
                }
            });

            workingYes.addEventListener('change', toggleWorkFields);
            workingNo.addEventListener('change', toggleWorkFields);

            // Ejecutar al cargar
            updateFinalPosition();
            toggleWorkFields();
        });
    </script>
@endsection

@endsection
