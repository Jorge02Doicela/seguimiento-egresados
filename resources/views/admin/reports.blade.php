@extends('layouts.admin')

@section('title', 'Reportes')

@section('content')
    <h1>Página de Reportes</h1>
    <p>Enlaces a reportes:</p>
    <ul>
        <li><a href="{{ route('admin.reports.excel') }}">Reporte Excel</a></li>
        <li><a href="{{ route('admin.reports.pdf') }}">Reporte PDF</a></li>
    </ul>
    <a href="{{ route('admin.surveys.dashboard') }}">Ver Dashboard de Encuestas</a>

@endsection
