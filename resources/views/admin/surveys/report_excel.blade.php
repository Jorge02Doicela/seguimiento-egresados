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
                        {{ $row->average_score ? number_format($row->average_score, 2) : 'N/A' }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
