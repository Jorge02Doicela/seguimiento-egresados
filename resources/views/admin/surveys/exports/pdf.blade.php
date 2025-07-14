<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 100px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #444;
            padding: 5px;
            text-align: left;
        }

        .table th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('images/logo_isus.png') }}" class="logo" alt="Logo ISUS">
        <h2>Resultados de la Encuesta: {{ $survey->title }}</h2>
        <p>Fecha: {{ now()->format('d/m/Y') }}</p>
    </div>

    @foreach ($questions as $question)
        <h4>{{ $loop->iteration }}. {{ $question->question_text }}</h4>
        <table class="table mb-3">
            <thead>
                <tr>
                    <th>Opción</th>
                    <th>Respuestas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($question->stats as $option => $count)
                    <tr>
                        <td>{{ $option }}</td>
                        <td>{{ $count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>

</html>
