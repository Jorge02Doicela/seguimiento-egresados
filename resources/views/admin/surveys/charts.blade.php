@extends('admin.layouts.app')

@section('title', 'Gráficos de Encuestas')

@section('content')
    <h1 class="mb-4">Visualización de Resultados (Chart.js)</h1>

    @foreach ($chartData as $index => $chart)
        <div class="card mb-4">
            <div class="card-header">
                <strong>{{ $chart['survey'] }}</strong> — {{ $chart['question'] }}
            </div>
            <div class="card-body">
                <canvas id="chart{{ $index }}"></canvas>
            </div>
        </div>
    @endforeach

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($chartData as $index => $chart)
                const ctx{{ $index }} = document.getElementById('chart{{ $index }}').getContext('2d');
                new Chart(ctx{{ $index }}, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($chart['labels']) !!},
                        datasets: [{
                            label: 'Respuestas',
                            data: {!! json_encode($chart['values']) !!},
                            backgroundColor: '#4e73df'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: false
                            }
                        }
                    }
                });
            @endforeach
        });
    </script>
@endpush
