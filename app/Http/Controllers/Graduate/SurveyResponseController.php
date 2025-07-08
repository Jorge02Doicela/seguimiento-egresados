<?php

namespace App\Http\Controllers\Graduate;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyResponseController extends Controller
{
    // Listar encuestas activas y disponibles para el egresado según fechas y carrera
    public function index()
    {
        $user = Auth::user();

        $surveys = Survey::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->where('career_id', $user->career_id) // filtro por carrera
            ->paginate(10);

        return view('graduate.surveys.index', compact('surveys'));
    }

    // Mostrar formulario de encuesta para responder
    public function show(Survey $survey)
    {
        $user = Auth::user();

        // Validar que encuesta esté activa, en fechas y sea de la carrera del usuario
        if (!$survey->is_active || !now()->between($survey->start_date, $survey->end_date) || $survey->career_id != $user->career_id) {
            return redirect()->route('graduate.surveys.index')->with('error', 'Encuesta no disponible.');
        }

        $survey->load('questions');

        return view('graduate.surveys.show', compact('survey'));
    }

    // Guardar respuestas enviadas
    public function store(Request $request, Survey $survey)
    {
        $user = Auth::user();

        // Validar que encuesta esté disponible y sea de la carrera
        if (!$survey->is_active || !now()->between($survey->start_date, $survey->end_date) || $survey->career_id != $user->career_id) {
            return redirect()->route('graduate.surveys.index')->with('error', 'Encuesta no disponible.');
        }

        // Verificar si ya respondió la encuesta (cualquier pregunta)
        $answered = $survey->questions()->whereHas('answers', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->exists();

        if ($answered) {
            return redirect()->route('graduate.surveys.index')->with('error', 'Ya has respondido esta encuesta.');
        }

        $survey->load('questions');

        // Validar respuestas según preguntas
        $rules = [];
        foreach ($survey->questions as $question) {
            if ($question->type === 'checkbox') {
                $rules['answers.' . $question->id] = ['array', 'min:1'];
            } else {
                $rules['answers.' . $question->id] = ['required'];
            }
        }
        $request->validate($rules);

        // Guardar respuestas
        foreach ($request->input('answers') as $questionId => $answerValue) {
            $question = Question::findOrFail($questionId);

            Answer::create([
                'user_id' => $user->id,
                'question_id' => $questionId,
                'answer_text' => is_array($answerValue) ? json_encode($answerValue) : $answerValue,
            ]);
        }

        return redirect()->route('graduate.surveys.index')->with('success', 'Encuesta respondida con éxito.');
    }
}
