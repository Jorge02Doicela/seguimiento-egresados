<?php

namespace App\Exports;

use App\Models\Answer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class SurveyReportExport implements FromView
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
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

        if (!empty($this->filters['survey_id'])) {
            $query->where('surveys.id', $this->filters['survey_id']);
        }
        if (!empty($this->filters['career_id'])) {
            $query->where('graduates.career_id', $this->filters['career_id']);
        }
        if (!empty($this->filters['cohort_year'])) {
            $query->whereYear('graduates.graduation_date', $this->filters['cohort_year']);
        }

        $results = $query->get();

        return view('admin.surveys.report_excel', compact('results'));
    }
}
