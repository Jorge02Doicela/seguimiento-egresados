@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4 font-open-sans">

    {{-- Formulario de filtros --}}
    <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-6 grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
        <div>
            <label for="year_from" class="block font-semibold">Cohorte desde</label>
            <input type="number" name="year_from" id="year_from" value="{{ request('year_from') }}" class="w-full border rounded px-2 py-1" />
        </div>

        <div>
            <label for="year_to" class="block font-semibold">Cohorte hasta</label>
            <input type="number" name="year_to" id="year_to" value="{{ request('year_to') }}" class="w-full border rounded px-2 py-1" />
        </div>

        <div>
            <label for="sector" class="block font-semibold">Sector</label>
            <select name="sector" id="sector" class="w-full border rounded px-2 py-1">
                <option value="">Todos</option>
                <option value="privado" @selected(request('sector')=='privado')>Privado</option>
                <option value="público" @selected(request('sector')=='público')>Público</option>
                <option value="freelance" @selected(request('sector')=='freelance')>Freelance</option>
            </select>
        </div>

        <div>
            <label for="gender" class="block font-semibold">Género</label>
            <select name="gender" id="gender" class="w-full border rounded px-2 py-1">
                <option value="">Todos</option>
                <option value="M" @selected(request('gender')=='M')>Masculino</option>
                <option value="F" @selected(request('gender')=='F')>Femenino</option>
                <option value="Otro" @selected(request('gender')=='Otro')>Otro</option>
            </select>
        </div>

        <div>
            <label for="position" class="block font-semibold">Buscar puesto</label>
            <input type="text" name="position" id="position" value="{{ request('position') }}" placeholder="Ej. Ingeniero" class="w-full border rounded px-2 py-1" />
        </div>

        <div>
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-dark w-full">Filtrar</button>
        </div>
    </form>

    {{-- Notificaciones no leídas --}}
    @foreach($unreadNotifications as $notification)
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 shadow-md mb-4 animate-fade-in-down" role="alert">
            <div class="flex items-center">
                <div class="py-1">
                    <svg class="fill-current h-6 w-6 text-blue-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M10 2a8 8 0 00-8 8c0 4.418 3.582 8 8 8s8-3.582 8-8a8 8 0 00-8-8zm0 14a6 6 0 110-12 6 6 0 010 12zm-1-7h2v4h-2V9zm0-3h2v2h-2V6z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-lg text-primary">{{ $notification->data['title'] }}</p>
                    <p class="text-sm text-text-main">{{ $notification->data['message'] }}</p>
                </div>
            </div>
        </div>
    @endforeach

    <h2 class="mb-6 text-3xl font-bold text-center text-primary-dark font-headings animate-fade-in">📊 Dashboard Estadístico – Administrador</h2>

    {{-- Gráficos principales --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <x-dashboard.card title="Empleabilidad por Cohorte" icon="trending-up" bg="primary">
            <canvas id="chartCohortes"></canvas>
        </x-dashboard.card>

        <x-dashboard.card title="Distribución por Sector Laboral" icon="briefcase" bg="secondary">
            <canvas id="chartSectores"></canvas>
        </x-dashboard.card>

        <x-dashboard.card title="Distribución por País" icon="globe" bg="info">
            <canvas id="chartPaises"></canvas>
        </x-dashboard.card>

        <x-dashboard.card title="Top Habilidades Técnicas" icon="cpu" bg="orange">
            <canvas id="chartSkills"></canvas>
        </x-dashboard.card>

        <x-dashboard.card title="Distribución por Género" icon="users" bg="purple">
            <canvas id="chartGenero"></canvas>
        </x-dashboard.card>

        <x-dashboard.card title="Top Ciudades de Trabajo" icon="map-pin" bg="success">
            <canvas id="chartCiudades"></canvas>
        </x-dashboard.card>
    </div>

    {{-- Tabla de salarios por puesto --}}
    <x-dashboard.table
        title="Salario Promedio por Puesto Técnico"
        :headers="['Puesto', 'Salario Promedio (USD)']"
        :rows="$salaryData->map(fn($item) => [$item->position, '$' . number_format($item->average_salary, 2)])"
    />

    {{-- Indicadores adicionales --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <x-dashboard.stat
            title="Egresados con Portafolio"
            :value="$withPortfolio"
            icon="bi-link"
            bg="primary"
        />
        <x-dashboard.stat
            title="Egresados con CV Subido"
            :value="$withCV"
            icon="bi-file-earmark-text"
            bg="success"
        />
        <x-dashboard.stat
            title="Participación en Encuestas"
            :value="$surveyParticipationRate . '%'"
            icon="bi-bar-chart-line"
            bg="warning"
        />
    </div>
</div>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Script de gráficas dinámicas --}}
<script>
    new Chart(document.getElementById('chartCohortes'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($cohortData->pluck('cohort_year')) !!},
            datasets: [{
                label: 'N° de Egresados',
                data: {!! json_encode($cohortData->pluck('total')) !!},
                backgroundColor: '#1E3A8A',
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    new Chart(document.getElementById('chartSectores'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($sectorData->pluck('sector')) !!},
            datasets: [{
                data: {!! json_encode($sectorData->pluck('total')) !!},
                backgroundColor: ['#3B82F6','#F59E0B','#1E3A8A','#E08D00','#BFD7ED']
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    new Chart(document.getElementById('chartPaises'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($countryData->pluck('country')) !!},
            datasets: [{
                data: {!! json_encode($countryData->pluck('total')) !!},
                backgroundColor: '#4B9CD3'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    new Chart(document.getElementById('chartSkills'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($skillData->pluck('name')) !!},
            datasets: [{
                data: {!! json_encode($skillData->pluck('total')) !!},
                backgroundColor: '#FFA500'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    new Chart(document.getElementById('chartGenero'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($genderData->pluck('gender')) !!},
            datasets: [{
                data: {!! json_encode($genderData->pluck('total')) !!},
                backgroundColor: ['#6B7280','#EF4444','#10B981']
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    new Chart(document.getElementById('chartCiudades'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($cityData->pluck('city')) !!},
            datasets: [{
                data: {!! json_encode($cityData->pluck('total')) !!},
                backgroundColor: '#10B981'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endsection
