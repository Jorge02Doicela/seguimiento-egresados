@extends('layouts.app')

@section('content')

    {{-- Notificaciones no leídas --}}
    @foreach($unreadNotifications as $notification)
        <div class="alert alert-info">
            <strong>{{ $notification->data['title'] }}</strong><br>
            {{ $notification->data['message'] }}
        </div>
    @endforeach

    <div class="container mt-5">
        <h2 class="mb-4">📊 Dashboard Estadístico – Administrador</h2>

        {{-- GRÁFICOS --}}
        <div class="row mb-5">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Empleabilidad por cohorte
                    </div>
                    <div class="card-body">
                        <canvas id="chartCohortes"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        Sectores laborales
                    </div>
                    <div class="card-body">
                        <canvas id="chartSectores"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLA --}}
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        Salario promedio por puesto
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Puesto</th>
                                    <th>Salario Promedio (USD)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salaryData as $item)
                                <tr>
                                    <td>{{ $item->position }}</td>
                                    <td>${{ number_format($item->average_salary, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CHART.JS CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- SCRIPT PARA LOS GRÁFICOS --}}
    <script>
        const chartCohortes = document.getElementById('chartCohortes');
        const chartSectores = document.getElementById('chartSectores');

        new Chart(chartCohortes, {
            type: 'bar',
            data: {
                labels: {!! json_encode($cohortData->pluck('cohort_year')) !!},
                datasets: [{
                    label: 'Egresados por cohorte',
                    data: {!! json_encode($cohortData->pluck('total')) !!},
                    backgroundColor: '#4e73df',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision:0
                        }
                    }
                }
            }
        });

        new Chart(chartSectores, {
            type: 'pie',
            data: {
                labels: {!! json_encode($sectorData->pluck('sector')) !!},
                datasets: [{
                    label: 'Distribución por sector',
                    data: {!! json_encode($sectorData->pluck('total')) !!},
                    backgroundColor: ['#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#8e44ad'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endsection
