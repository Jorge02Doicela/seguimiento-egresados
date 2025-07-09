@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Perfil</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('graduate.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <br>
            <div class="mb-3">
                <label class="form-label">¿Está trabajando actualmente?</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_working" id="working_yes" value="1"
                            {{ old('is_working', $graduate->is_working) ? 'checked' : '' }}>
                        <label class="form-check-label" for="working_yes">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_working" id="working_no" value="0"
                            {{ old('is_working', $graduate->is_working) ? '' : 'checked' }}>
                        <label class="form-check-label" for="working_no">No</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="cohort_year" class="form-label">Año de cohorte</label>
                <input type="number" name="cohort_year" id="cohort_year" class="form-control"
                    value="{{ old('cohort_year', $graduate->cohort_year) }}" required>
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">Género</label>
                <select name="gender" id="gender" class="form-select" required>
                    <option value="M" @selected(old('gender', $graduate->gender) == 'M')>Masculino</option>
                    <option value="F" @selected(old('gender', $graduate->gender) == 'F')>Femenino</option>
                    <option value="Otro" @selected(old('gender', $graduate->gender) == 'Otro')>Otro</option>
                </select>
            </div>

            <div id="workFields">
                <div class="mb-3">
                    <label for="company" class="form-label">Empresa</label>
                    <input type="text" name="company" id="company" class="form-control"
                        value="{{ old('company', $graduate->company) }}">
                </div>

                <div class="mb-3">
                    <label for="position" class="form-label">Cargo</label>
                    <input type="text" name="position" id="position" class="form-control"
                        value="{{ old('position', $graduate->position) }}">
                </div>

                <div class="mb-3">
                    <label for="salary" class="form-label">Salario</label>
                    <input type="number" step="0.01" name="salary" id="salary" class="form-control"
                        value="{{ old('salary', $graduate->salary) }}">
                </div>

                <div class="mb-3">
                    <label for="sector" class="form-label">Sector</label>
                    <select name="sector" id="sector" class="form-select">
                        <option value="" @selected(old('sector', $graduate->sector) == '')>Seleccione</option>
                        <option value="privado" @selected(old('sector', $graduate->sector) == 'privado')>Privado</option>
                        <option value="público" @selected(old('sector', $graduate->sector) == 'público')>Público</option>
                        <option value="freelance" @selected(old('sector', $graduate->sector) == 'freelance')>Freelance</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="portfolio_url" class="form-label">URL Portafolio</label>
                <input type="url" name="portfolio_url" id="portfolio_url" class="form-control"
                    value="{{ old('portfolio_url', $graduate->portfolio_url) }}">
            </div>

            <div class="mb-3">
                <label for="cv" class="form-label">Subir CV (PDF, DOC, DOCX)</label>
                <input type="file" name="cv" id="cv" class="form-control" accept=".pdf,.doc,.docx">
                @if ($graduate->cv_path)
                    <small>Archivo actual: <a href="{{ asset('storage/' . $graduate->cv_path) }}" target="_blank">Ver
                            CV</a></small>
                @endif
            </div>

            <div class="mb-3">
                <label for="country" class="form-label">País</label>
                <input type="text" name="country" id="country" class="form-control"
                    value="{{ old('country', $graduate->country) }}">
            </div>

            <div class="mb-3">
                <label for="city" class="form-label">Ciudad</label>
                <input type="text" name="city" id="city" class="form-control"
                    value="{{ old('city', $graduate->city) }}">
            </div>

            <button type="submit" class="btn btn-success">Actualizar Perfil</button>
        </form>

        <hr>

        <h3>Habilidades</h3>
        <ul>
            @foreach ($graduate->skills as $skill)
                <li>
                    {{ $skill->name }}
                    <form action="{{ route('graduate.profile.skills.remove') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="skill_id" value="{{ $skill->id }}">
                        <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <form action="{{ route('graduate.profile.skills.add') }}" method="POST" class="mt-3">
            @csrf
            <select name="skill_id" class="form-select" required>
                <option value="">Selecciona una habilidad para agregar</option>
                @foreach ($allSkills as $skill)
                    @if (!$graduate->skills->contains($skill->id))
                        <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                    @endif
                @endforeach
            </select>
            <button class="btn btn-primary mt-2" type="submit">Agregar Habilidad</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const workingYes = document.getElementById('working_yes');
            const workingNo = document.getElementById('working_no');
            const workFields = document.getElementById('workFields');

            function toggleWorkFields() {
                if (workingYes.checked) {
                    workFields.style.display = 'block';
                } else {
                    workFields.style.display = 'none';
                }
            }

            workingYes.addEventListener('change', toggleWorkFields);
            workingNo.addEventListener('change', toggleWorkFields);

            toggleWorkFields(); // Estado inicial
        });
    </script>
@endsection
