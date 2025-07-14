<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Barryvdh\DomPDF\Facade\Pdf;

class SurveyPdfController extends Controller
{
    public function export(Survey $survey)
    {
        $survey->load('questions.answers');

        $pdf = Pdf::loadView('admin.surveys.exports.pdf', compact('survey'));

        return $pdf->download('survey_results_' . $survey->id . '.pdf');
    }
}
