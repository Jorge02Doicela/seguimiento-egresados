@extends('layouts.app')

@section('content')
    <h1>Dashboard de Resultados de Encuestas</h1>
    <div class="mb-4">
        <a href="{{ route('admin.surveys.export.pdf', $survey) }}" class="btn btn-primary">Exportar PDF</a>
        <a href="{{ route('admin.surveys.export.excel', $survey) }}" class="btn btn-success">Exportar Excel</a>
    </div>

    <form method="GET" action="{{ route('admin.surveys.dashboard') }}" class="mb-4">
        <label for="survey_id">Seleccione una encuesta:</label>
        <select name="survey_id" id="survey_id" onchange="this.form.submit()">
            @foreach ($surveys as $s)
                <option value="{{ $s->id }}" @if ($survey && $survey->id == $s->id) selected @endif>{{ $s->title }}
                </option>
            @endforeach
        </select>
    </form>

    @if ($survey)
        <h2>Encuesta: {{ $survey->title }}</h2>
        <p>{{ $survey->description }}</p>

        <div>
            @foreach ($results as $questionId => $data)
                <div class="mb-5">
                    <h4>{{ $data['question_text'] }}</h4>
                    <canvas id="chart-{{ $questionId }}" style="max-width: 600px;"></canvas>
                    @if ($data['type'] === 'scale')
                        <p class="mt-2"><strong>Total de respuestas:</strong> {{ $data['results']['total_responses'] }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p>No se encontró ninguna encuesta.</p>
    @endif
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($results as $questionId => $data)
                const ctx{{ $questionId }} = document.getElementById('chart-{{ $questionId }}').getContext(
                    '2d');
                @if (in_array($data['type'], ['option', 'boolean', 'checkbox']))
                    new Chart(ctx{{ $questionId }}, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode(array_keys($data['results'])) !!},
                            datasets: [{
                                label: 'Cantidad de respuestas',
                                data: {!! json_encode(array_values($data['results'])) !!},
                                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    precision: 0
                                }
                            }
                        }
                    });
                @elseif ($data['type'] === 'scale')
                    new Chart(ctx{{ $questionId }}, {
                        type: 'bar',
                        data: {
                            labels: ['Promedio'],
                            datasets: [{
                                label: '{{ $data['question_text'] }}',
                                data: [{{ $data['results']['average'] }}],
                                backgroundColor: 'rgba(255, 159, 64, 0.7)',
                                borderColor: 'rgba(255, 159, 64, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    max: 5
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return 'Promedio: ' + context.parsed.x;
                                        }
                                    }
                                }
                            }
                        }
                    });
                @endif
            @endforeach
        });
    </script>
@endsection
