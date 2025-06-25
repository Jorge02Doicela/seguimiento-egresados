<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    // Mostrar listado de encuestas
    public function index()
    {
        $surveys = Survey::with('questions')->paginate(10);
        return view('admin.surveys.index', compact('surveys'));
    }

    // Mostrar formulario para crear nueva encuesta
    public function create()
    {
        return view('admin.surveys.create');
    }

    // Guardar encuesta y sus preguntas
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.type' => 'required|in:option,scale,text',
            'questions.*.options' => 'nullable|array',
            'questions.*.scale_min' => 'nullable|integer',
            'questions.*.scale_max' => 'nullable|integer',
        ]);

        // Crear encuesta
        $survey = Survey::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Crear preguntas
        foreach ($request->questions as $q) {
            $survey->questions()->create([
                'question_text' => $q['question_text'],
                'type' => $q['type'],
                'options' => $q['options'] ?? null,
                'scale_min' => $q['scale_min'] ?? null,
                'scale_max' => $q['scale_max'] ?? null,
            ]);
        }

        return redirect()->route('admin.surveys.index')->with('success', 'Encuesta creada correctamente');
    }

    // Mostrar detalles de una encuesta
    public function show(Survey $survey)
    {
        $survey->load('questions');
        return view('admin.surveys.show', compact('survey'));
    }

    // Mostrar formulario para editar encuesta
    public function edit(Survey $survey)
    {
        $survey->load('questions');
        return view('admin.surveys.edit', compact('survey'));
    }

    // Actualizar encuesta y preguntas
    public function update(Request $request, Survey $survey)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'questions.*.id' => 'nullable|integer|exists:questions,id',
            'questions.*.question_text' => 'required|string',
            'questions.*.type' => 'required|in:option,scale,text',
            'questions.*.options' => 'nullable|array',
            'questions.*.scale_min' => 'nullable|integer',
            'questions.*.scale_max' => 'nullable|integer',
        ]);

        // Actualizar encuesta
        $survey->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Actualizar o crear preguntas
        foreach ($request->questions as $q) {
            if (isset($q['id'])) {
                // Actualizar pregunta existente
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
                // Crear nueva pregunta
                $survey->questions()->create([
                    'question_text' => $q['question_text'],
                    'type' => $q['type'],
                    'options' => $q['options'] ?? null,
                    'scale_min' => $q['scale_min'] ?? null,
                    'scale_max' => $q['scale_max'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.surveys.index')->with('success', 'Encuesta actualizada correctamente');
    }

    // Eliminar encuesta y sus preguntas (cascade)
    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('admin.surveys.index')->with('success', 'Encuesta eliminada correctamente');
    }
}
