<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reporte de Encuesta</title>
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }
    </style>
</head>

<body>
    <h1>Resumen de Resultados - {{ $survey->title }}</h1>

    @foreach ($results as $res)
        <h3>{{ $res['question_text'] }} ({{ strtoupper($res['type']) }})</h3>

        @if ($res['type'] === 'scale')
            <p>Promedio: {{ $res['results']['average'] }} ({{ $res['results']['total_responses'] }} respuestas)</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Respuesta</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($res['results'] as $option => $count)
                        <tr>
                            <td>{{ $option }}</td>
                            <td>{{ $count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach
</body>

</html>
