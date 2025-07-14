<table>
    <thead>
        <tr>
            <th>Pregunta</th>
            <th>Respuesta</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($survey->questions as $question)
            @foreach ($question->answers as $answer)
                <tr>
                    <td>{{ $question->question_text }}</td>
                    <td>{{ $answer->answer_text }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
