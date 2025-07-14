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
        // Marcar notificaciones como leídas
        Auth::user()->unreadNotifications->markAsRead();

        $graduate = Auth::user()->graduate;
        $careerId = $graduate->career_id;

        // Buscar ID de la carrera General si existe
        $generalCareer = Career::where('name', 'General')->first();

        $surveyQuery = Survey::query()
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->where(function ($query) use ($careerId, $generalCareer) {
                $query->where('career_id', $careerId);

                if ($generalCareer) {
                    $query->orWhere('career_id', $generalCareer->id);
                }
            });

        $surveys = $surveyQuery->get();

        return view('graduate.surveys.index', compact('surveys'));
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

        foreach ($questions as $question) {
            $rules['answers.' . $question->id] = 'required';
        }

        $validated = $request->validate($rules);

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
