<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Career;
use App\Models\Question;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::with('career')->paginate(10);
        return view('admin.surveys.index', compact('surveys'));
    }

    public function create()
    {
        $careers = Career::all();
        return view('admin.surveys.create', compact('careers'));
    }

    public function store(Request $request)
    {
        // Filtrar preguntas incompletas (sin texto o sin tipo)
        $questionsFiltered = array_filter($request->input('questions', []), function ($q) {
            return !empty($q['question_text']) && !empty($q['type']);
        });

        // Reemplazar el array original por el filtrado
        $request->merge(['questions' => $questionsFiltered]);

        $this->validateSurvey($request);

        $survey = Survey::create([
            'career_id'   => $request->career_id,
            'title'       => $request->title,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'is_active'   => $request->has('is_active'),
        ]);

        foreach ($request->questions as $q) {
            $survey->questions()->create([
                'question_text' => $q['question_text'],
                'type'          => $q['type'],
                'options'       => (in_array($q['type'], ['option', 'checkbox']) && isset($q['options'])) ? $q['options'] : null,
                'scale_min'     => $q['type'] === 'scale' ? ($q['scale_min'] ?? 1) : null,
                'scale_max'     => $q['type'] === 'scale' ? ($q['scale_max'] ?? 5) : null,
            ]);
        }


        return redirect()->route('admin.surveys.index')->with('success', 'Encuesta creada exitosamente.');
    }

    public function edit(Survey $survey)
    {
        $survey->load('questions');
        $careers = Career::all();
        return view('admin.surveys.edit', compact('survey', 'careers'));
    }

    public function update(Request $request, Survey $survey)
    {
        // Filtrar preguntas incompletas (sin texto o sin tipo)
        $questionsFiltered = array_filter($request->input('questions', []), function ($q) {
            return !empty($q['question_text']) && !empty($q['type']);
        });

        $request->merge(['questions' => $questionsFiltered]);

        $this->validateSurvey($request);

        $survey->update([
            'career_id'   => $request->career_id,
            'title'       => $request->title,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'is_active'   => $request->has('is_active'),
        ]);

        $existingIds = $survey->questions->pluck('id')->toArray();
        $receivedIds = [];

        foreach ($request->questions as $q) {
            if (isset($q['id']) && in_array($q['id'], $existingIds)) {
                $question = $survey->questions()->find($q['id']);
                $question->update([
                    'question_text' => $q['question_text'],
                    'type'          => $q['type'],
                    'options'       => (in_array($q['type'], ['option', 'checkbox']) && isset($q['options'])) ? $q['options'] : null,
                    'scale_min'     => $q['type'] === 'scale' ? ($q['scale_min'] ?? 1) : null,
                    'scale_max'     => $q['type'] === 'scale' ? ($q['scale_max'] ?? 5) : null,
                ]);

                $receivedIds[] = $q['id'];
            } else {
                $survey->questions()->create([
                    'question_text' => $q['question_text'],
                    'type'          => $q['type'],
                    'options'       => in_array($q['type'], ['option', 'checkbox']) ? $q['options'] : null,
                    'scale_min'     => $q['type'] === 'scale' ? ($q['scale_min'] ?? 1) : null,
                    'scale_max'     => $q['type'] === 'scale' ? ($q['scale_max'] ?? 5) : null,
                ]);
            }
        }

        $questionsToDelete = array_diff($existingIds, $receivedIds);
        if (!empty($questionsToDelete)) {
            Question::whereIn('id', $questionsToDelete)->delete();
        }

        return redirect()->route('admin.surveys.index')->with('success', 'Encuesta actualizada correctamente.');
    }

    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('admin.surveys.index')->with('success', 'Encuesta eliminada.');
    }

    /**
     * Validación para crear o actualizar encuestas.
     */
    private function validateSurvey(Request $request)
    {
        $request->validate([
            'career_id'                 => 'required|exists:careers,id',
            'title'                     => 'required|string|max:255',
            'description'               => 'nullable|string',
            'start_date'                => 'nullable|date',
            'end_date'                  => 'nullable|date|after_or_equal:start_date',
            'is_active'                 => 'nullable|in:0,1',
            'questions'                 => 'required|array|min:1',
            'questions.*.id'            => 'nullable|integer|exists:questions,id',
            'questions.*.question_text' => 'required|string',
            'questions.*.type'          => 'required|in:option,checkbox,scale,boolean',
            'questions.*.options'       => 'nullable|array',
            'questions.*.options.*'     => 'string|min:1',
            'questions.*.scale_min'     => 'nullable|integer',
            'questions.*.scale_max'     => 'nullable|integer',
        ]);
    }
    public function clone(Survey $survey)
    {
        \DB::beginTransaction();

        try {
            // Clonar la encuesta principal (sin guardar aún)
            $newSurvey = $survey->replicate();
            $newSurvey->title = $survey->title . ' (Copia)';
            $newSurvey->start_date = null;
            $newSurvey->end_date = null;
            $newSurvey->is_active = false;
            $newSurvey->save(); // guardar para obtener ID

            // Clonar preguntas relacionadas
            foreach ($survey->questions as $question) {
                $newQuestion = $question->replicate();
                $newQuestion->survey_id = $newSurvey->id;
                $newQuestion->save();
            }

            \DB::commit();

            // Redirigir a la vista de edición del nuevo survey para poder modificarlo
            return redirect()->route('admin.surveys.edit', $newSurvey)
                ->with('success', 'Encuesta clonada exitosamente. Puedes modificarla ahora.');
        } catch (\Exception $e) {
            \DB::rollBack();

            // Puedes loguear el error $e->getMessage() si quieres

            return redirect()->route('admin.surveys.index')
                ->with('error', 'Error al clonar la encuesta. Inténtalo nuevamente.');
        }
    }
}
