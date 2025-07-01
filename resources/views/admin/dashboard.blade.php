@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard de Egresados</h1>

    <div class="row">
        <!-- Empleabilidad por cohorte -->
        <div class="col-md-6">
            <h5>Empleabilidad por año de graduación</h5>
            <canvas id="cohorteChart"></canvas>
        </div>

        <!-- Sectores laborales -->
        <div class="col-md-6">
            <h5>Distribución por sector laboral</h5>
            <canvas id="sectorChart"></canvas>
        </div>
    </div>

    <!-- Salarios por puesto -->
    <div class="mt-5">
        <h5>Salario promedio por rol técnico</h5>
        <canvas id="salarioChart"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de barras por cohorte
    const cohorteCtx = document.getElementById('cohorteChart').getContext('2d');
    new Chart(cohorteCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($empleabilidadPorAnio->toArray())) !!},
            datasets: [{
                label: 'Egresados',
                data: {!! json_encode(array_values($empleabilidadPorAnio->toArray())) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        }
    });

    // Gráfico circular por sector
    const sectorCtx = document.getElementById('sectorChart').getContext('2d');
    new Chart(sectorCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_keys($sectores->toArray())) !!},
            datasets: [{
                data: {!! json_encode(array_values($sectores->toArray())) !!},
                backgroundColor: ['#36A2EB', '#FFCE56', '#4BC0C0']
            }]
        }
    });

    // Gráfico de barras por salario
    const salarioCtx = document.getElementById('salarioChart').getContext('2d');
    new Chart(salarioCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($salarios->toArray())) !!},
            datasets: [{
                label: 'Salario promedio',
                data: {!! json_encode(array_values($salarios->toArray())) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            }]
        }
    });
</script>
@endsection
