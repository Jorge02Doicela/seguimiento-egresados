<?php

namespace App\Http\Controllers\Graduate;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyResponseController extends Controller
{
    // Mostrar listado de encuestas activas para responder
    public function index()
    {
        // Puedes filtrar encuestas activas, por ejemplo con un campo 'active' en Survey
        $surveys = Survey::where('active', true)->paginate(10);
        return view('graduate.surveys.index', compact('surveys'));
    }

    // Mostrar formulario para responder encuesta específica
    public function show(Survey $survey)
    {
        $survey->load('questions');
        return view('graduate.surveys.show', compact('survey'));
    }

    // Guardar respuestas enviadas por el egresado
    public function store(Request $request, Survey $survey)
    {
        $user = Auth::user();

        // Validar que respondieron todas las preguntas
        $rules = [];
        foreach ($survey->questions as $question) {
            $rules['answers.' . $question->id] = ['required'];
        }
        $request->validate($rules);

        // Evitar respuestas duplicadas para la misma encuesta y usuario
        $alreadyAnswered = Answer::where('user_id', $user->id)
            ->whereIn('question_id', $survey->questions->pluck('id'))
            ->exists();

        if ($alreadyAnswered) {
            return redirect()->route('graduate.surveys.index')->with('error', 'Ya has respondido esta encuesta.');
        }

        // Guardar respuestas
        foreach ($request->input('answers') as $questionId => $answerValue) {
            Answer::create([
                'user_id' => $user->id,
                'question_id' => $questionId,
                'answer_text' => $answerValue,
            ]);
        }

        return redirect()->route('graduate.surveys.index')->with('success', 'Encuesta respondida correctamente.');
    }
}
