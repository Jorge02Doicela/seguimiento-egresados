@extends('layouts.admin')

@section('title', 'Dashboard de Encuestas')

@section('content')
    <h1>Dashboard de Encuestas</h1>

    <form method="GET" action="{{ route('admin.surveys.dashboard') }}" class="row mb-4">
        <div class="col-md-3">
            <label for="survey_id">Encuesta</label>
            <select name="survey_id" id="survey_id" class="form-select">
                <option value="">Todas</option>
                @foreach ($surveys as $survey)
                    <option value="{{ $survey->id }}" @selected(request('survey_id') == $survey->id)>{{ $survey->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="career_id">Carrera</label>
            <select name="career_id" id="career_id" class="form-select">
                <option value="">Todas</option>
                @foreach ($careers as $career)
                    <option value="{{ $career->id }}" @selected(request('career_id') == $career->id)>{{ $career->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="cohort_year">Cohorte</label>
            <select name="cohort_year" id="cohort_year" class="form-select">
                <option value="">Todas</option>
                @foreach ($cohorts as $year)
                    <option value="{{ $year }}" @selected(request('cohort_year') == $year)>{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    @if ($results->isEmpty())
        <p>No hay datos para mostrar con estos filtros.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Pregunta</th>
                    <th>Tipo</th>
                    <th>Total Respuestas</th>
                    <th>Promedio (si aplica)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $row)
                    <tr>
                        <td>{{ $row->question_text }}</td>
                        <td>{{ ucfirst($row->type) }}</td>
                        <td>{{ $row->total_answers }}</td>
                        <td>
                            @if ($row->type === 'scale')
                                {{ number_format($row->average_score, 2) }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('admin.surveys.export.excel', request()->query()) }}" class="btn btn-success">Exportar Excel</a>
        <a href="{{ route('admin.surveys.export.pdf', request()->query()) }}" class="btn btn-danger">Exportar PDF</a>
    @endif
@endsection
