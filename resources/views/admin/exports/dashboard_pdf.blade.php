<table>
    <thead>
        <tr>
            <th>Cohorte</th>
            <th>Total de Egresados</th>
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
