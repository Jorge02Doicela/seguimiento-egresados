<?php

namespace App\Exports;

use App\Models\Survey;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SurveyResultsExport implements FromView
{
    protected $survey;

    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }

    public function view(): View
    {
        $survey = $this->survey->load('questions.answers');

        return view('admin.surveys.exports.excel', compact('survey'));
    }
}
