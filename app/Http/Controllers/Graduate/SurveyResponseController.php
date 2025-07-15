<?php

namespace App\Http\Controllers\Graduate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Career;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;

class SurveyResponseController extends Controller
{
    /**
     * Mostrar las encuestas activas correspondientes a la carrera del egresado
     * y las generales (carrera llamada 'General').
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        Auth::user()->unreadNotifications->markAsRead();

        $graduate = Auth::user()->graduate;
        $careerId = $graduate->career_id;

        $generalCareer = Career::where('name', 'General')->first();

        $careerIds = [$careerId];
        if ($generalCareer) {
            $careerIds[] = $generalCareer->id;
        }

        $surveys = Survey::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->whereIn('career_id', $careerIds)
            ->get();

        return view('graduate.surveys.index', compact('surveys', 'generalCareer'));
    }

    /**
     * Mostrar la encuesta con sus preguntas para responder.
     */
    public function show(Survey $survey)
    {
        $user = Auth::user();
        $careerId = $user->graduate->career_id ?? null;

        $generalCareerId = Career::where('name', 'General')->value('id');

        if (!in_array($survey->career_id, [$careerId, $generalCareerId])) {
            abort(403, 'No autorizado para ver esta encuesta.');
        }

        $hasAnswered = Answer::where('user_id', $user->id)
            ->whereIn('question_id', $survey->questions()->pluck('id'))
            ->exists();

        return view('graduate.surveys.show', compact('survey', 'hasAnswered'));
    }

    /**
     * Guardar respuestas enviadas.
     */
    public function submit(Request $request, Survey $survey)
    {
        $user = Auth::user();
        $careerId = $user->graduate->career_id ?? null;

        $generalCareerId = Career::where('name', 'General')->value('id');

        if (!in_array($survey->career_id, [$careerId, $generalCareerId])) {
            abort(403, 'No autorizado para enviar respuestas a esta encuesta.');
        }

        $alreadyAnswered = Answer::where('user_id', $user->id)
            ->whereIn('question_id', $survey->questions()->pluck('id'))
            ->exists();

        if ($alreadyAnswered) {
            return redirect()->route('graduate.surveys.index')
                ->with('error', 'Ya has respondido esta encuesta.');
        }

        $questions = $survey->questions;
        $rules = [];
        $messages = [];

        foreach ($questions as $question) {
            $field = 'answers.' . $question->id;

            if ($question->type === 'checkbox') {
                $rules[$field] = 'required|array|min:1';
                $messages[$field . '.required'] = 'Debe seleccionar al menos una opción para la pregunta: "' . $question->question_text . '"';
                $messages[$field . '.min'] = 'Debe seleccionar al menos una opción para la pregunta: "' . $question->question_text . '"';
            } else {
                $rules[$field] = 'required';
                $messages[$field . '.required'] = 'Debe responder la pregunta: "' . $question->question_text . '"';
            }
        }

        $validated = $request->validate($rules, $messages);

        foreach ($validated['answers'] as $questionId => $answerValue) {
            Answer::create([
                'user_id' => $user->id,
                'question_id' => $questionId,
                'answer_text' => is_array($answerValue) ? json_encode($answerValue) : $answerValue,
            ]);
        }

        return redirect()->route('graduate.surveys.index')
            ->with('success', 'Encuesta respondida correctamente.');
    }
}
