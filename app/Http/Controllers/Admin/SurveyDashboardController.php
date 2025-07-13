<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Graduate;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;    // Paquete barryvdh/laravel-dompdf para generación PDF
use Maatwebsite\Excel\Facades\Excel;  // Paquete para exportar Excel
use App\Exports\SurveyReportExport;    // Exportación personalizada de reporte

class SurveyDashboardController extends Controller
{
    /**
     * Mostrar dashboard con resultados estadísticos y filtros opcionales.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Obtener todas las encuestas ordenadas por título para el filtro
        $surveys = Survey::orderBy('title')->get();

        // Construcción de consulta para obtener estadísticas agrupadas por pregunta
        $query = Answer::query()
            ->select(
                'questions.question_text',
                'questions.type',
                DB::raw('COUNT(answers.id) as total_answers'),             // Total de respuestas para la pregunta
                DB::raw('AVG(CAST(answers.answer_text AS UNSIGNED)) as average_score') // Promedio para respuestas numéricas
            )
            ->join('questions', 'answers.question_id', '=', 'questions.id') // Relacionar preguntas
            ->join('graduates', 'answers.user_id', '=', 'graduates.user_id') // Relacionar egresados que respondieron
            ->join('surveys', 'questions.survey_id', '=', 'surveys.id')     // Relacionar encuesta
            ->groupBy('questions.id', 'questions.question_text', 'questions.type'); // Agrupar por pregunta para estadística

        // Aplicar filtros si vienen en la petición
        if ($request->filled('survey_id')) {
            $query->where('surveys.id', $request->survey_id);
        }
        if ($request->filled('career_id')) {
            $query->where('graduates.career_id', $request->career_id);
        }
        if ($request->filled('cohort_year')) {
            $query->where('graduates.cohort_year', $request->cohort_year);
        }

        // Ejecutar consulta y obtener resultados
        $results = $query->get();

        // Datos para filtros en la vista
        $careers = \App\Models\Career::orderBy('name')->get();
        $cohorts = Graduate::select('cohort_year as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Renderizar la vista con datos para mostrar dashboard y filtros
        return view('admin.surveys.dashboard', compact('surveys', 'results', 'careers', 'cohorts'));
    }


    /**
     * Exportar reporte de encuesta filtrado a Excel.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel(Request $request)
    {
        // Validar filtros recibidos
        $request->validate([
            'survey_id' => 'nullable|exists:surveys,id',
            'career_id' => 'nullable|exists:careers,id',
            'cohort_year' => 'nullable|integer|min:1900|max:' . date('Y'),
        ]);

        // Preparar filtros para exportación
        $filters = $request->only(['survey_id', 'career_id', 'cohort_year']);

        // Ejecutar exportación usando la clase SurveyReportExport personalizada
        return Excel::download(new SurveyReportExport($filters), 'survey_report.xlsx');
    }

    /**
     * Exportar reporte de encuesta filtrado a PDF.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportPDF(Request $request)
    {
        // Validar filtros recibidos
        $request->validate([
            'survey_id' => 'nullable|exists:surveys,id',
            'career_id' => 'nullable|exists:careers,id',
            'cohort_year' => 'nullable|integer|min:1900|max:' . date('Y'),
        ]);

        // Preparar filtros para consulta
        $filters = $request->only(['survey_id', 'career_id', 'cohort_year']);

        // Construir consulta similar a la de dashboard para obtener datos filtrados
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

        // Aplicar filtros solo si existen
        if (!empty($filters['survey_id'])) {
            $query->where('surveys.id', $filters['survey_id']);
        }
        if (!empty($filters['career_id'])) {
            $query->where('graduates.career_id', $filters['career_id']);
        }
        if (!empty($filters['cohort_year'])) {
            // Filtrar por año de graduación
            $query->where('graduates.cohort_year', $filters['cohort_year']);
        }

        // Obtener resultados filtrados para reporte
        $results = $query->get();

        // Generar PDF usando la vista 'report_pdf' y los resultados
        $pdf = PDF::loadView('admin.surveys.report_pdf', compact('results'));

        // Descargar archivo PDF generado
        return $pdf->download('survey_report.pdf');
    }

    /**
     * Mostrar gráficos estadísticos con datos agregados por preguntas de encuestas.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function charts(Request $request)
    {
        // Cargar encuestas con preguntas y respuestas para análisis
        $surveys = Survey::with('questions.answers')->get();

        $chartData = [];

        // Recorrer todas las encuestas
        foreach ($surveys as $survey) {
            // Recorrer preguntas para generar datos por tipo
            foreach ($survey->questions as $question) {
                // Solo para tipos que permiten gráficos: opción múltiple, escala, booleano
                if (in_array($question->type, ['option', 'scale', 'boolean'])) {
                    $data = [];

                    // Contar respuestas por valor para generar etiquetas y cantidades
                    foreach ($question->answers as $answer) {
                        $val = $answer->answer_text;
                        $data[$val] = ($data[$val] ?? 0) + 1;
                    }

                    // Construir estructura para gráfico
                    $chartData[] = [
                        'survey' => $survey->title,
                        'question' => $question->question_text,
                        'labels' => array_keys($data),
                        'values' => array_values($data),
                    ];
                }
            }
        }

        // Renderizar vista con datos para mostrar gráficos estadísticos
        return view('admin.surveys.charts', compact('chartData'));
    }
}
