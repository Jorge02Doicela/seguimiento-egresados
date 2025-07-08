<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Reporte de Encuestas</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background: #eee;
        }
    </style>
</head>

<body>
    <h2>Reporte de Encuestas</h2>
    <table>
        <thead>
            <tr>
                <th>Pregunta</th>
                <th>Tipo</th>
                <th>Total Respuestas</th>
                <th>Promedio</th>
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
</body>

</html>
