@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-10 px-6 font-open-sans animate-fade-in">

        <h1
            class="mb-8 text-5xl font-extrabold text-center text-primary-dark font-headings animate-fade-in-up leading-tight">
            Dashboard Estadístico – Administrador</h1>
        <div class="flex justify-end gap-4 mb-8">
            <a href="{{ route('admin.dashboard.export.excel', request()->all()) }}"
                class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition">Exportar a Excel</a>
            <a href="{{ route('admin.dashboard.export.pdf', request()->all()) }}"
                class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 transition">Exportar a PDF</a>
        </div>

        {{-- Formulario de filtros --}}
        <form method="GET" action="{{ route('admin.dashboard') }}"
            class="mb-10 p-7 bg-white rounded-xl shadow-2xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6 items-end animate-slide-in-down border border-gray-200">
            <div>
                <label for="year_from" class="block text-gray-corporate text-sm font-semibold mb-2">Cohorte desde</label>
                <input type="number" name="year_from" id="year_from" value="{{ request('year_from') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-secondary focus:ring-blue-secondary transition duration-200 ease-in-out px-4 py-2.5 text-text-main placeholder-text-light"
                    placeholder="Ej: 2020" />
            </div>

            <div>
                <label for="year_to" class="block text-gray-corporate text-sm font-semibold mb-2">Cohorte hasta</label>
                <input type="number" name="year_to" id="year_to" value="{{ request('year_to') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-secondary focus:ring-blue-secondary transition duration-200 ease-in-out px-4 py-2.5 text-text-main placeholder-text-light"
                    placeholder="Ej: 2024" />
            </div>

            <div>
                <label for="sector" class="block text-gray-corporate text-sm font-semibold mb-2">Sector</label>
                <select name="sector" id="sector"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-secondary focus:ring-blue-secondary transition duration-200 ease-in-out px-4 py-2.5 text-text-main">
                    <option value="">Todos</option>
                    <option value="privado" @selected(request('sector') == 'privado')>Privado</option>
                    <option value="público" @selected(request('sector') == 'público')>Público</option>
                    <option value="freelance" @selected(request('sector') == 'freelance')>Freelance</option>
                </select>
            </div>

            <div>
                <label for="gender" class="block text-gray-corporate text-sm font-semibold mb-2">Género</label>
                <select name="gender" id="gender"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-secondary focus:ring-blue-secondary transition duration-200 ease-in-out px-4 py-2.5 text-text-main">
                    <option value="">Todos</option>
                    <option value="M" @selected(request('gender') == 'M')>Masculino</option>
                    <option value="F" @selected(request('gender') == 'F')>Femenino</option>
                    <option value="Otro" @selected(request('gender') == 'Otro')>Otro</option>
                </select>
            </div>

            <div>
                <label for="position" class="block text-gray-corporate text-sm font-semibold mb-2">Buscar puesto</label>
                <input type="text" name="position" id="position" value="{{ request('position') }}"
                    placeholder="Ej. Desarrollador"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-secondary focus:ring-blue-secondary transition duration-200 ease-in-out px-4 py-2.5 text-text-main placeholder-text-light" />
            </div>

            <div>
                <button type="submit"
                    class="bg-primary text-white font-bold py-2.5 px-5 rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary-light focus:ring-opacity-75 w-full transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                    Filtrar Resultados
                </button>
            </div>
        </form>

        {{-- Notificaciones no leídas --}}
        @foreach ($unreadNotifications as $notification)
            <div class="bg-blue-200 border-l-4 border-blue-secondary text-blue-800 p-5 shadow-lg mb-8 animate-fade-in-down rounded-lg flex items-center space-x-4"
                role="alert">
                <div class="flex-shrink-0">
                    <svg class="fill-current h-7 w-7 text-blue-secondary" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 2a8 8 0 00-8 8c0 4.418 3.582 8 8 8s8-3.582 8-8a8 8 0 00-8-8zm0 14a6 6 0 110-12 6 6 0 010 12zm-1-7h2v4h-2V9zm0-3h2v2h-2V6z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-lg text-primary-dark mb-0.5">{{ $notification->data['title'] }}</p>
                    <p class="text-sm text-text-main">{{ $notification->data['message'] }}</p>
                </div>
            </div>
        @endforeach

        {{-- Gráficos principales --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <x-dashboard.card title="Empleabilidad por Cohorte" icon="trending-up"
                class="bg-primary-dark text-white shadow-3xl animate-pop-in">
                <div class="relative h-64"> {{-- Altura fija para gráficos --}}
                    <canvas id="chartCohortes"></canvas>
                </div>
            </x-dashboard.card>

            <x-dashboard.card title="Distribución por Sector Laboral" icon="briefcase"
                class="bg-secondary text-white shadow-3xl animate-pop-in">
                <div class="relative h-64"> {{-- Altura fija para gráficos --}}
                    <canvas id="chartSectores"></canvas>
                </div>
            </x-dashboard.card>

            <x-dashboard.card title="Distribución por País" icon="globe"
                class="bg-blue-institutional text-white shadow-3xl animate-pop-in">
                <div class="relative h-64"> {{-- Altura fija para gráficos --}}
                    <canvas id="chartPaises"></canvas>
                </div>
            </x-dashboard.card>

            <x-dashboard.card title="Top Habilidades Técnicas" icon="cpu"
                class="bg-accent text-white shadow-3xl animate-pop-in">
                <div class="relative h-64"> {{-- Altura fija para gráficos --}}
                    <canvas id="chartSkills"></canvas>
                </div>
            </x-dashboard.card>

            <x-dashboard.card title="Distribución por Género" icon="users"
                class="bg-gray-corporate text-white shadow-3xl animate-pop-in">
                <div class="relative h-64"> {{-- Altura fija para gráficos --}}
                    <canvas id="chartGenero"></canvas>
                </div>
            </x-dashboard.card>

            <x-dashboard.card title="Top Ciudades de Trabajo" icon="map-pin"
                class="bg-logo-primary text-white shadow-3xl animate-pop-in">
                <div class="relative h-64"> {{-- Altura fija para gráficos --}}
                    <canvas id="chartCiudades"></canvas>
                </div>
            </x-dashboard.card>
        </div>

        {{-- Tabla de salarios por puesto --}}
        <x-dashboard.table title="Salario Promedio por Puesto Técnico" :headers="['Puesto', 'Salario Promedio (USD)']" :rows="$salaryData->map(fn($item) => [$item->position, '$' . number_format($item->average_salary, 2)])"
            class="bg-white rounded-xl shadow-2xl animate-fade-in-up border border-gray-200" />

        {{-- Indicadores adicionales --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
            <x-dashboard.stat title="Egresados con Portafolio" :value="$withPortfolio" icon="bi-link"
                class="bg-primary text-white shadow-lg animate-slide-in-left rounded-xl" />
            <x-dashboard.stat title="Egresados con CV Subido" :value="$withCV" icon="bi-file-earmark-text"
                class="bg-yellow-accent text-white shadow-lg animate-pop-in rounded-xl" />
            <x-dashboard.stat title="Participación en Encuestas" :value="$surveyParticipationRate . '%'" icon="bi-bar-chart-line"
                class="bg-blue-secondary text-white shadow-lg animate-slide-in-right rounded-xl" />
        </div>
    </div>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>

    {{-- Script de gráficas dinámicas --}}
    <script>
        // Configuración base para todos los gráficos
        const baseChartOptions = {
            responsive: true,
            maintainAspectRatio: false, // Importante para controlar el tamaño con la altura del contenedor
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(30, 58, 138, 0.9)', // primary
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#1E3A8A', // primary
                    borderWidth: 1,
                    cornerRadius: 5,
                    titleFont: {
                        family: 'Open Sans',
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        family: 'Open Sans',
                        size: 12
                    },
                    padding: 10
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: '#BFD7ED', // logo-blue-200 para contraste en fondos oscuros
                        font: {
                            family: 'Open Sans',
                            size: 11
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(243, 244, 246, 0.1)', // gray-light con transparencia
                        drawBorder: false
                    },
                    ticks: {
                        color: '#BFD7ED', // logo-blue-200
                        font: {
                            family: 'Open Sans',
                            size: 11
                        }
                    }
                }
            }
        };

        // Chart Cohortes
        new Chart(document.getElementById('chartCohortes'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($cohortData->pluck('cohort_year')) !!},
                datasets: [{
                    label: 'N° de Egresados',
                    data: {!! json_encode($cohortData->pluck('total')) !!},
                    backgroundColor: '#3B82F6', // primary-light
                    borderRadius: 8,
                    barPercentage: 0.7 // Controla el ancho de las barras
                }]
            },
            options: {
                ...baseChartOptions, // Hereda opciones base
                plugins: {
                    ...baseChartOptions.plugins,
                    tooltip: {
                        ...baseChartOptions.plugins.tooltip,
                        backgroundColor: 'rgba(59, 130, 246, 0.9)', // secondary
                        borderColor: '#3B82F6' // secondary
                    }
                },
                scales: {
                    x: {
                        ...baseChartOptions.scales.x
                    },
                    y: {
                        ...baseChartOptions.scales.y
                    }
                }
            }
        });

        // Chart Sectores
        new Chart(document.getElementById('chartSectores'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($sectorData->pluck('sector')) !!},
                datasets: [{
                    data: {!! json_encode($sectorData->pluck('total')) !!},
                    backgroundColor: ['#3B82F6', '#F59E0B', '#1E3A8A', '#E08D00', '#BFD7ED', '#142d6d'],
                    borderColor: '#1F2937', // dark para mejor contraste
                    borderWidth: 2
                }]
            },
            options: {
                ...baseChartOptions, // Hereda opciones base
                plugins: {
                    ...baseChartOptions.plugins,
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#BFD7ED', // logo-blue-200
                            font: {
                                family: 'Open Sans',
                                size: 12
                            },
                            boxWidth: 20, // Tamaño de las cajas de color en la leyenda
                            padding: 15
                        }
                    },
                    tooltip: {
                        ...baseChartOptions.plugins.tooltip,
                        backgroundColor: 'rgba(59, 130, 246, 0.9)', // secondary
                        borderColor: '#3B82F6' // secondary
                    }
                },
                scales: { // Eliminar escalas para Doughnut/Pie charts
                    x: {
                        display: false
                    },
                    y: {
                        display: false
                    }
                }
            }
        });

        // Chart Paises
        new Chart(document.getElementById('chartPaises'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($countryData->pluck('country')) !!},
                datasets: [{
                    data: {!! json_encode($countryData->pluck('total')) !!},
                    backgroundColor: '#6AA1F8', // primary-lighter
                    borderRadius: 8,
                    barPercentage: 0.7
                }]
            },
            options: {
                ...baseChartOptions, // Hereda opciones base
                plugins: {
                    ...baseChartOptions.plugins,
                    tooltip: {
                        ...baseChartOptions.plugins.tooltip,
                        backgroundColor: 'rgba(106, 161, 248, 0.9)', // primary-lighter
                        borderColor: '#6AA1F8' // primary-lighter
                    }
                },
                scales: {
                    x: {
                        ...baseChartOptions.scales.x
                    },
                    y: {
                        ...baseChartOptions.scales.y
                    }
                }
            }
        });

        // Chart Skills (Horizontal Bar)
        new Chart(document.getElementById('chartSkills'), {
            type: 'bar', // Es 'bar' pero con indexAxis: 'y' para horizontal
            data: {
                labels: {!! json_encode($skillData->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($skillData->pluck('total')) !!},
                    backgroundColor: '#FCD34D', // yellow-accent-light
                    borderRadius: 8,
                    barPercentage: 0.7
                }]
            },
            options: {
                ...baseChartOptions, // Hereda opciones base
                indexAxis: 'y', // Hace que sea un gráfico de barras horizontal
                plugins: {
                    ...baseChartOptions.plugins,
                    tooltip: {
                        ...baseChartOptions.plugins.tooltip,
                        backgroundColor: 'rgba(252, 211, 77, 0.9)', // yellow-accent-light
                        borderColor: '#FCD34D' // yellow-accent-light
                    }
                },
                scales: {
                    x: {
                        ...baseChartOptions.scales.x
                    },
                    y: {
                        ...baseChartOptions.scales.y
                    }
                }
            }
        });

        // Chart Genero
        new Chart(document.getElementById('chartGenero'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($genderData->pluck('gender')) !!},
                datasets: [{
                    data: {!! json_encode($genderData->pluck('total')) !!},
                    backgroundColor: ['#6B7280', '#EF4444', '#10B981',
                    '#BFD7ED'], // gray, red, green, logo-blue-200
                    borderColor: '#1F2937', // dark
                    borderWidth: 2
                }]
            },
            options: {
                ...baseChartOptions, // Hereda opciones base
                plugins: {
                    ...baseChartOptions.plugins,
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#BFD7ED', // logo-blue-200
                            font: {
                                family: 'Open Sans',
                                size: 12
                            },
                            boxWidth: 20,
                            padding: 15
                        }
                    },
                    tooltip: {
                        ...baseChartOptions.plugins.tooltip,
                        backgroundColor: 'rgba(107, 114, 128, 0.9)', // text-light
                        borderColor: '#6B7280' // text-light
                    }
                },
                scales: {
                    x: {
                        display: false
                    },
                    y: {
                        display: false
                    }
                }
            }
        });

        // Chart Ciudades
        new Chart(document.getElementById('chartCiudades'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($cityData->pluck('city')) !!},
                datasets: [{
                    data: {!! json_encode($cityData->pluck('total')) !!},
                    backgroundColor: '#0D326F', // logo-primary
                    borderRadius: 8,
                    barPercentage: 0.7
                }]
            },
            options: {
                ...baseChartOptions, // Hereda opciones base
                plugins: {
                    ...baseChartOptions.plugins,
                    tooltip: {
                        ...baseChartOptions.plugins.tooltip,
                        backgroundColor: 'rgba(13, 50, 111, 0.9)', // logo-primary
                        borderColor: '#0D326F' // logo-primary
                    }
                },
                scales: {
                    x: {
                        ...baseChartOptions.scales.x
                    },
                    y: {
                        ...baseChartOptions.scales.y
                    }
                }
            }
        });
    </script>
@endsection
