<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;

class ReportController extends Controller
{
    /**
     * Mostrar la vista principal de reportes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.reports');
    }

    /**
     * Generar datos para reporte Excel y retornar vista correspondiente.
     *
     * @return \Illuminate\View\View
     */
    public function excel()
    {
        $results = $this->getReportResults();

        return view('admin.surveys.report_excel', compact('results'));
    }

    /**
     * Generar datos para reporte PDF y retornar vista correspondiente.
     *
     * @return \Illuminate\View\View
     */
    public function pdf()
    {
        $results = $this->getReportResults();

        return view('admin.surveys.report_pdf', compact('results'));
    }

    /**
     * Método privado que obtiene los resultados del reporte con cálculo de promedio para preguntas tipo 'scale'.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getReportResults()
    {
        // Obtener todas las preguntas con sus respuestas relacionadas
        $questions = Question::with('answers')->get();

        // Mapear cada pregunta para calcular totales y promedio si aplica
        return $questions->map(function ($question) {
            $total = $question->answers->count();

            $average = null;

            if ($question->type === 'scale') {
                $sum = 0;
                $count = 0;

                foreach ($question->answers as $answer) {
                    $value = null;

                    // Intentar decodificar respuesta como JSON (array numérico)
                    $decoded = json_decode($answer->answer_text, true);

                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        // Tomar el primer valor numérico encontrado en el array
                        foreach ($decoded as $val) {
                            if (is_numeric($val)) {
                                $value = (float) $val;
                                break;
                            }
                        }
                    } else {
                        // Si no es JSON, comprobar si el texto es numérico directamente
                        if (is_numeric($answer->answer_text)) {
                            $value = (float) $answer->answer_text;
                        }
                    }

                    // Acumular para cálculo promedio si valor válido
                    if (!is_null($value)) {
                        $sum += $value;
                        $count++;
                    }
                }

                $average = $count > 0 ? $sum / $count : null;
            }

            // Retornar objeto con datos clave para reportes
            return (object) [
                'question_text'  => $question->question_text,
                'type'           => $question->type,
                'total_answers'  => $total,
                'average_score'  => $average,
            ];
        });
    }
}
