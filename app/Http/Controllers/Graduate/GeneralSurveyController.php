<?php

namespace App\Http\Controllers\Graduate;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralSurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::whereNull('career_id')
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->get();

        return view('graduate.general-surveys.index', compact('surveys'));
    }

    public function show(Survey $survey)
    {
        if ($survey->career_id !== null) {
            abort(403, 'No autorizado para esta encuesta.');
        }

        $survey->load('questions.options'); // Cargar preguntas y opciones si tienes relación "options"

        return view('graduate.general-surveys.show', compact('survey'));
    }

    public function submit(Request $request, Survey $survey)
    {
        if ($survey->career_id !== null) {
            abort(403, 'No autorizado para esta encuesta.');
        }

        $user = Auth::user();

        // Validación simple de respuestas
        $rules = [];
        foreach ($survey->questions as $question) {
            $rules['answers.' . $question->id] = 'required';
        }
        $validated = $request->validate($rules);

        // Guardar respuestas
        foreach ($validated['answers'] as $questionId => $answerValue) {
            Answer::create([
                'user_id' => $user->id,
                'question_id' => $questionId,
                'answer_text' => is_array($answerValue) ? json_encode($answerValue) : $answerValue,
            ]);
        }

        return redirect()->route('graduate.general-surveys.index')
            ->with('success', 'Encuesta enviada correctamente.');
    }
}
