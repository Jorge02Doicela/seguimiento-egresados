<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Career;
use App\Models\Graduate;
use App\Notifications\NewSurveyNotification;
use Illuminate\Support\Facades\Notification;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::with('career')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.surveys.index', compact('surveys'));
    }

    public function create()
    {
        $careers = Career::all(); // incluye todas las carreras para elegir, puede agregarse "General" como opción en la vista
        return view('admin.surveys.create', compact('careers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'career_id' => 'nullable|exists:careers,id', // nullable para permitir encuestas generales
            'is_active' => 'nullable|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|in:option,checkbox,scale,boolean',
            'questions.*.options' => 'nullable|string',
            'questions.*.scale_min' => 'nullable|integer',
            'questions.*.scale_max' => 'nullable|integer',
        ]);

        $survey = Survey::create([
            'title' => $request->title,
            'description' => $request->description,
            'career_id' => $request->career_id,
            'is_active' => $request->has('is_active'),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        foreach ($request->questions as $q) {
            $options = null;
            if (in_array($q['type'], ['option', 'checkbox'])) {
                $opts = array_map('trim', explode(',', $q['options'] ?? ''));
                $options = json_encode($opts);
            }

            Question::create([
                'survey_id' => $survey->id,
                'question_text' => $q['text'],
                'type' => $q['type'],
                'options' => $options,
                'scale_min' => $q['type'] === 'scale' ? ($q['scale_min'] ?? 1) : null,
                'scale_max' => $q['type'] === 'scale' ? ($q['scale_max'] ?? 5) : null,
            ]);
        }

        // Notificar a egresados si la encuesta está activa
        if ($survey->is_active) {
            $graduates = Graduate::with('user')->get();
            Notification::send($graduates->pluck('user'), new NewSurveyNotification($survey));
        }

        return redirect()->route('admin.surveys.index')->with('success', 'Encuesta creada con éxito.');
    }

    public function edit(Survey $survey)
    {
        $careers = Career::all();
        $survey->load('questions');
        return view('admin.surveys.edit', compact('survey', 'careers'));
    }

    public function update(Request $request, Survey $survey)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'career_id' => 'nullable|exists:careers,id', // nullable para permitir encuestas generales
            'is_active' => 'nullable|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'questions' => 'required|array|min:1',
            'questions.*.id' => 'nullable|exists:questions,id',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|in:option,checkbox,scale,boolean',
            'questions.*.options' => 'nullable|string',
            'questions.*.scale_min' => 'nullable|integer',
            'questions.*.scale_max' => 'nullable|integer',
        ]);

        $survey->update([
            'title' => $request->title,
            'description' => $request->description,
            'career_id' => $request->career_id,
            'is_active' => $request->has('is_active'),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        $existingQuestionIds = $survey->questions()->pluck('id')->toArray();
        $newQuestionIds = [];

        foreach ($request->questions as $q) {
            $options = null;
            if (in_array($q['type'], ['option', 'checkbox'])) {
                $opts = array_map('trim', explode(',', $q['options'] ?? ''));
                $options = json_encode($opts);
            }

            if (!empty($q['id']) && in_array($q['id'], $existingQuestionIds)) {
                $question = Question::find($q['id']);
                $question->update([
                    'question_text' => $q['text'],
                    'type' => $q['type'],
                    'options' => $options,
                    'scale_min' => $q['type'] === 'scale' ? ($q['scale_min'] ?? 1) : null,
                    'scale_max' => $q['type'] === 'scale' ? ($q['scale_max'] ?? 5) : null,
                ]);
                $newQuestionIds[] = $q['id'];
            } else {
                $newQuestion = Question::create([
                    'survey_id' => $survey->id,
                    'question_text' => $q['text'],
                    'type' => $q['type'],
                    'options' => $options,
                    'scale_min' => $q['type'] === 'scale' ? ($q['scale_min'] ?? 1) : null,
                    'scale_max' => $q['type'] === 'scale' ? ($q['scale_max'] ?? 5) : null,
                ]);
                $newQuestionIds[] = $newQuestion->id;
            }
        }

        $toDelete = array_diff($existingQuestionIds, $newQuestionIds);
        if (!empty($toDelete)) {
            Question::destroy($toDelete);
        }

        // Notificar si se activó en esta edición
        if ($survey->is_active && $survey->wasChanged('is_active')) {
            $graduates = Graduate::with('user')->get();
            Notification::send($graduates->pluck('user'), new NewSurveyNotification($survey));
        }

        return redirect()->route('admin.surveys.index')->with('success', 'Encuesta actualizada con éxito.');
    }

    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('admin.surveys.index')->with('success', 'Encuesta eliminada.');
    }
}
