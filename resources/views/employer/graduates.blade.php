@extends('layouts.app')

@section('title', 'Buscar Egresados')

@section('content')
<h2>Buscar Egresados</h2>

<form method="GET" class="row g-3 mb-4">
    <div class="col-md-3">
        <label class="form-label">Cohorte</label>
        <input type="number" name="cohort_year" class="form-control" value="{{ $filters['cohort_year'] ?? '' }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Género</label>
        <select name="gender" class="form-select">
            <option value="">-- Todos --</option>
            <option value="M" {{ ($filters['gender'] ?? '') === 'M' ? 'selected' : '' }}>Masculino</option>
            <option value="F" {{ ($filters['gender'] ?? '') === 'F' ? 'selected' : '' }}>Femenino</option>
            <option value="Otro" {{ ($filters['gender'] ?? '') === 'Otro' ? 'selected' : '' }}>Otro</option>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Sector laboral</label>
        <select name="sector" class="form-select">
            <option value="">-- Todos --</option>
            <option value="privado" {{ ($filters['sector'] ?? '') === 'privado' ? 'selected' : '' }}>Privado</option>
            <option value="público" {{ ($filters['sector'] ?? '') === 'público' ? 'selected' : '' }}>Público</option>
            <option value="freelance" {{ ($filters['sector'] ?? '') === 'freelance' ? 'selected' : '' }}>Freelance</option>
        </select>
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </div>
</form>

<!-- Mostrar total resultados -->
<p>Mostrando {{ $graduates->total() }} resultados</p>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Cohorte</th>
            <th>Género</th>
            <th>Empresa</th>
            <th>Puesto</th>
            <th>Sector</th>
        </tr>
    </thead>
    <tbody>
        @forelse($graduates as $grad)
        <tr>
            <td>{{ $grad->user->name }}</td>
            <td>{{ $grad->cohort_year }}</td>
            <td>{{ $grad->gender }}</td>
            <td>{{ $grad->company }}</td>
            <td>{{ $grad->position }}</td>
            <td>{{ $grad->sector }}</td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center">No se encontraron egresados.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $graduates->withQueryString()->links() }}
@endsection
