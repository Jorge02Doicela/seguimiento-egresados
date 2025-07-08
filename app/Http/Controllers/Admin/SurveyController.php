<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Career;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    // Mostrar listado de encuestas con relación a carrera
    public function index()
    {
        $surveys = Survey::with('career')->paginate(10);
        return view('admin.surveys.index', compact('surveys'));
    }

    // Mostrar formulario para crear encuesta
    public function create()
    {
        $careers = Career::all();
        return view('admin.surveys.create', compact('careers'));
    }

    // Guardar encuesta y preguntas
    public function store(Request $request)
    {
        $request->validate([
            'career_id' => 'required|exists:careers,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'nullable|in:0,1',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.type' => 'required|in:option,checkbox,scale,boolean',
            'questions.*.options' => 'nullable',
            'questions.*.options.*' => 'nullable|string|min:1',
            'questions.*.options.*' => 'required|string|min:1',
            'questions.*.scale_min' => 'nullable|integer',
            'questions.*.scale_max' => 'nullable|integer',
        ]);

        $survey = Survey::create([
            'career_id' => $request->career_id,
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        foreach ($request->questions as $q) {
            $survey->questions()->create([
                'question_text' => $q['question_text'],
                'type' => $q['type'],
                'options' => $q['options'] ?? null,
                'scale_min' => $q['scale_min'] ?? null,
                'scale_max' => $q['scale_max'] ?? null,
            ]);
        }

        return redirect()->route('admin.surveys.index')->with('success', 'Encuesta creada exitosamente.');
    }


    // Mostrar formulario para editar encuesta
    public function edit(Survey $survey)
    {
        $survey->load('questions');
        $careers = Career::all();
        return view('admin.surveys.edit', compact('survey', 'careers'));
    }

    // Actualizar encuesta y preguntas
    public function update(Request $request, Survey $survey)
    {
        $request->validate([
            'career_id' => 'required|exists:careers,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'nullable|in:0,1',
            'questions' => 'required|array|min:1',
            'questions.*.id' => 'nullable|integer|exists:questions,id',
            'questions.*.question_text' => 'required|string',
            'questions.*.type' => 'required|in:option,checkbox,scale,boolean',
            'questions.*.options' => 'nullable',
            'questions.*.options.*' => 'nullable|string|min:1',
            'questions.*.options.*' => 'required|string|min:1',
            'questions.*.scale_min' => 'nullable|integer',
            'questions.*.scale_max' => 'nullable|integer',
        ]);

        $survey->update([
            'career_id' => $request->career_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->has('is_active'),
        ]);

        foreach ($request->questions as $q) {
            if (isset($q['id'])) {
                $question = $survey->questions()->find($q['id']);
                if ($question) {
                    $question->update([
                        'question_text' => $q['question_text'],
                        'type' => $q['type'],
                        'options' => $q['options'] ?? null,
                        'scale_min' => $q['scale_min'] ?? null,
                        'scale_max' => $q['scale_max'] ?? null,
                    ]);
                }
            } else {
                $survey->questions()->create([
                    'question_text' => $q['question_text'],
                    'type' => $q['type'],
                    'options' => $q['options'] ?? null,
                    'scale_min' => $q['scale_min'] ?? null,
                    'scale_max' => $q['scale_max'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.surveys.index')->with('success', 'Encuesta actualizada correctamente.');
    }


    // Eliminar encuesta
    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('admin.surveys.index')->with('success', 'Encuesta eliminada.');
    }

    // Clonar encuesta con preguntas
    public function clone(Survey $survey)
    {
        $newSurvey = $survey->replicate();
        $newSurvey->title .= ' (Copia)';
        $newSurvey->is_active = false;
        $newSurvey->start_date = null;
        $newSurvey->end_date = null;
        $newSurvey->save();

        foreach ($survey->questions as $q) {
            $newSurvey->questions()->create($q->only([
                'question_text',
                'type',
                'options',
                'scale_min',
                'scale_max'
            ]));
        }

        return redirect()->route('admin.surveys.edit', $newSurvey)->with('success', 'Encuesta clonada.');
    }
}
