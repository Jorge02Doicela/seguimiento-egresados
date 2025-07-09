<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Graduate;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;    // barryvdh/laravel-dompdf
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SurveyReportExport;

class SurveyDashboardController extends Controller
{
    // Mostrar dashboard con filtros
    public function index(Request $request)
    {
        $surveys = Survey::orderBy('title')->get();

        $query = Answer::query()
            ->select(
                'questions.question_text',
                'questions.type',
                DB::raw('COUNT(answers.id) as total_answers'),
                DB::raw('AVG(CAST(answers.answer_text AS UNSIGNED)) as average_score')
            )
            ->join('questions', 'answers.question_id', '=', 'questions.id')
            ->join('graduates', 'answers.user_id', '=', 'graduates.user_id')
            ->join('surveys', 'questions.survey_id', '=', 'surveys.id')
            ->groupBy('questions.id', 'questions.question_text', 'questions.type');

        if ($request->filled('survey_id')) {
            $query->where('surveys.id', $request->survey_id);
        }
        if ($request->filled('career_id')) {
            $query->where('graduates.career_id', $request->career_id);
        }
        if ($request->filled('cohort_year')) {
            $query->where('graduates.cohort_year', $request->cohort_year);
        }

        $results = $query->get();

        $careers = \App\Models\Career::orderBy('name')->get();
        $cohorts = Graduate::select('cohort_year as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');


        return view('admin.surveys.dashboard', compact('surveys', 'results', 'careers', 'cohorts'));
    }


    // Exportar Excel
    public function exportExcel(Request $request)
    {
        $request->validate([
            'survey_id' => 'nullable|exists:surveys,id',
            'career_id' => 'nullable|exists:careers,id',
            'cohort_year' => 'nullable|integer|min:1900|max:' . date('Y'),
        ]);

        return Excel::download(new SurveyReportExport($filters), 'survey_report.xlsx');
    }

    // Exportar PDF
    public function exportPDF(Request $request)
    {
        $request->validate([
            'survey_id' => 'nullable|exists:surveys,id',
            'career_id' => 'nullable|exists:careers,id',
            'cohort_year' => 'nullable|integer|min:1900|max:' . date('Y'),
        ]);


        $query = Answer::query()
            ->select(
                'questions.question_text',
                'questions.type',
                DB::raw('COUNT(answers.id) as total_answers'),
                DB::raw('AVG(CAST(answers.answer_text AS UNSIGNED)) as average_score')
            )
            ->join('questions', 'answers.question_id', '=', 'questions.id')
            ->join('graduates', 'answers.user_id', '=', 'graduates.user_id')
            ->join('surveys', 'questions.survey_id', '=', 'surveys.id')
            ->groupBy('questions.id');

        if (!empty($filters['survey_id'])) {
            $query->where('surveys.id', $filters['survey_id']);
        }
        if (!empty($filters['career_id'])) {
            $query->where('graduates.career_id', $filters['career_id']);
        }
        if (!empty($filters['cohort_year'])) {
            $query->whereYear('graduates.graduation_date', $filters['cohort_year']);
        }

        $results = $query->get();

        $pdf = PDF::loadView('admin.surveys.report_pdf', compact('results'));

        return $pdf->download('survey_report.pdf');
    }

    // Mostrar gráficos estadísticos de resultados
    public function charts(Request $request)
    {
        $surveys = Survey::with('questions.answers')->get();

        $chartData = [];

        foreach ($surveys as $survey) {
            foreach ($survey->questions as $question) {
                if (in_array($question->type, ['option', 'scale', 'boolean'])) {
                    $data = [];

                    // Recuento de respuestas por opción
                    foreach ($question->answers as $answer) {
                        $val = $answer->answer_text;
                        $data[$val] = ($data[$val] ?? 0) + 1;
                    }

                    $chartData[] = [
                        'survey' => $survey->title,
                        'question' => $question->question_text,
                        'labels' => array_keys($data),
                        'values' => array_values($data),
                    ];
                }
            }
        }

        return view('admin.surveys.charts', compact('chartData'));
    }
}
