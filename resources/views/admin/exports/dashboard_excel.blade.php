<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte Egresados</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #eee;
        }

        h2 {
            margin-top: 30px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <h1>Reporte de Egresados ISUS</h1>
    <p>Fecha: {{ now()->format('d/m/Y H:i') }}</p>

    <h2>Cohortes</h2>
    <table>
        <thead>
            <tr>
                <th>Cohorte</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cohortData as $item)
                <tr>
                    <td>{{ $item->cohort_year }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Sectores</h2>
    <table>
        <thead>
            <tr>
                <th>Sector</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sectorData as $item)
                <tr>
                    <td>{{ $item->sector ?? 'No especificado' }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
