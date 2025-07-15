<?php

namespace App\Exports;

use App\Models\Survey;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SurveyDashboardExport implements FromArray, WithHeadings
{
    protected $survey;

    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }

    public function headings(): array
    {
        return ['Pregunta', 'Tipo', 'Respuesta', 'Valor'];
    }

    public function array(): array
    {
        $data = [];

        foreach ($this->survey->questions as $question) {
            if (in_array($question->type, ['option', 'boolean', 'checkbox'])) {
                $answers = DB::table('answers')
                    ->select('answer_text', DB::raw('COUNT(*) as total'))
                    ->where('question_id', $question->id)
                    ->groupBy('answer_text')
                    ->get();

                $results = [];

                foreach ($answers as $ans) {
                    if ($question->type === 'checkbox') {
                        $items = json_decode($ans->answer_text, true);
                        if (is_array($items)) {
                            foreach ($items as $item) {
                                $results[$item] = ($results[$item] ?? 0) + $ans->total;
                            }
                        }
                    } else {
                        $results[$ans->answer_text] = $ans->total;
                    }
                }

                foreach ($results as $answer => $count) {
                    $data[] = [
                        $question->question_text,
                        $question->type,
                        $answer,
                        $count
                    ];
                }
            } elseif ($question->type === 'scale') {
                $stats = DB::table('answers')
                    ->where('question_id', $question->id)
                    ->selectRaw('AVG(CAST(answer_text AS DECIMAL(10,2))) as avg, COUNT(*) as total')
                    ->first();

                $data[] = [
                    $question->question_text,
                    $question->type,
                    'Promedio',
                    round($stats->avg ?? 0, 2)
                ];

                $data[] = [
                    $question->question_text,
                    $question->type,
                    'Respuestas',
                    $stats->total
                ];
            }
        }

        return $data;
    }
}
