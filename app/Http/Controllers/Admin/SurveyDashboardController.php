<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\SurveyDashboardExport;
use Maatwebsite\Excel\Facades\Excel;



class SurveyDashboardController extends Controller
{
    /**
     * Mostrar dashboard con resumen de resultados de encuestas.
     */
    public function index(Request $request)
    {
        $surveyId = $request->input('survey_id');

        // Obtener encuestas para el filtro
        $surveys = Survey::orderBy('created_at', 'desc')->get();

        // Si no se especifica encuesta, tomar la más reciente
        if (!$surveyId && $surveys->count()) {
            $surveyId = $surveys->first()->id;
        }

        $survey = Survey::with('questions')->find($surveyId);

        $results = [];

        if ($survey) {
            foreach ($survey->questions as $question) {
                $questionResults = [];

                if (in_array($question->type, ['option', 'boolean', 'checkbox'])) {
                    // Para opciones y boolean, contar respuestas por opción
                    $answers = DB::table('answers')
                        ->select('answer_text', DB::raw('COUNT(*) as total'))
                        ->whereIn('question_id', [$question->id])
                        ->groupBy('answer_text')
                        ->get();

                    $questionResults = $answers->mapWithKeys(function ($item) {
                        return [$item->answer_text => $item->total];
                    })->toArray();

                    // En checkbox guardamos JSON, necesitamos contar cada opción individualmente
                    if ($question->type === 'checkbox') {
                        // Acomodar resultados para checkbox
                        $counts = [];
                        foreach ($questionResults as $jsonAnswer => $count) {
                            $answersArray = json_decode($jsonAnswer, true);
                            if (is_array($answersArray)) {
                                foreach ($answersArray as $ans) {
                                    $counts[$ans] = ($counts[$ans] ?? 0) + $count;
                                }
                            }
                        }
                        $questionResults = $counts;
                    }
                } elseif ($question->type === 'scale') {
                    // Para escala, calcular promedio y contar respuestas
                    $stats = DB::table('answers')
                        ->where('question_id', $question->id)
                        ->selectRaw('AVG(CAST(answer_text AS DECIMAL(10,2))) as avg, COUNT(*) as total')
                        ->first();

                    $questionResults = [
                        'average' => round($stats->avg ?? 0, 2),
                        'total_responses' => $stats->total,
                    ];
                }

                $results[$question->id] = [
                    'question_text' => $question->question_text,
                    'type' => $question->type,
                    'results' => $questionResults,
                ];
            }
        }

        return view('admin.surveys.dashboard', compact('surveys', 'survey', 'results'));
    }

    public function exportPDF(Request $request)
    {
        $surveyId = $request->input('survey_id');

        $surveys = Survey::orderBy('created_at', 'desc')->get();

        if (!$surveyId && $surveys->count()) {
            $surveyId = $surveys->first()->id;
        }

        $survey = Survey::with('questions')->find($surveyId);
        $results = [];

        if ($survey) {
            foreach ($survey->questions as $question) {
                $questionResults = [];

                if (in_array($question->type, ['option', 'boolean', 'checkbox'])) {
                    $answers = DB::table('answers')
                        ->select('answer_text', DB::raw('COUNT(*) as total'))
                        ->where('question_id', $question->id)
                        ->groupBy('answer_text')
                        ->get();

                    $questionResults = $answers->mapWithKeys(function ($item) {
                        return [$item->answer_text => $item->total];
                    })->toArray();

                    if ($question->type === 'checkbox') {
                        $counts = [];
                        foreach ($questionResults as $jsonAnswer => $count) {
                            $answersArray = json_decode($jsonAnswer, true);
                            if (is_array($answersArray)) {
                                foreach ($answersArray as $ans) {
                                    $counts[$ans] = ($counts[$ans] ?? 0) + $count;
                                }
                            }
                        }
                        $questionResults = $counts;
                    }
                } elseif ($question->type === 'scale') {
                    $stats = DB::table('answers')
                        ->where('question_id', $question->id)
                        ->selectRaw('AVG(CAST(answer_text AS DECIMAL(10,2))) as avg, COUNT(*) as total')
                        ->first();

                    $questionResults = [
                        'average' => round($stats->avg ?? 0, 2),
                        'total_responses' => $stats->total,
                    ];
                }

                $results[$question->id] = [
                    'question_text' => $question->question_text,
                    'type' => $question->type,
                    'results' => $questionResults,
                ];
            }
        }

        $pdf = Pdf::loadView('admin.surveys.exports.dashboard-pdf', compact('survey', 'results'));
        return $pdf->download('dashboard_encuesta.pdf');
    }

    public function exportExcel(Request $request, Survey $survey)
    {
        $export = new SurveyDashboardExport($survey);

        return Excel::download($export, 'dashboard_encuesta.xlsx');
    }
}
