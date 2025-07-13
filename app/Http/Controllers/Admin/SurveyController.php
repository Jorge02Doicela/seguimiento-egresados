<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Career;
use App\Models\Question;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Mostrar listado paginado de encuestas con su relación a carrera.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener encuestas con la relación 'career' para evitar consultas N+1
        $surveys = Survey::with('career')->paginate(10);
        return view('admin.surveys.index', compact('surveys'));
    }

    /**
     * Mostrar formulario para crear una nueva encuesta.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Obtener todas las carreras para seleccionar en el formulario
        $careers = Career::all();
        return view('admin.surveys.create', compact('careers'));
    }

    /**
     * Almacenar una nueva encuesta junto con sus preguntas.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Filtrar preguntas para eliminar aquellas incompletas (sin texto o tipo)
        $questionsFiltered = array_filter($request->input('questions', []), function ($q) {
            return !empty($q['question_text']) && !empty($q['type']);
        });

        // Sobrescribir el array original con el filtrado para validación y almacenamiento
        $request->merge(['questions' => $questionsFiltered]);

        // Validar los datos del request (incluye validación de preguntas)
        $this->validateSurvey($request);

        // Crear la encuesta con los datos validados
        $survey = Survey::create([
            'career_id'   => $request->career_id,
            'title'       => $request->title,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'is_active'   => $request->has('is_active'), // Checkbox convertido a booleano
        ]);

        // Iterar y crear preguntas relacionadas a esta encuesta
        foreach ($request->questions as $q) {
            $survey->questions()->create([
                'question_text' => $q['question_text'],
                'type'          => $q['type'],
                // Guardar opciones solo si es tipo opción o checkbox
                'options'       => (in_array($q['type'], ['option', 'checkbox']) && isset($q['options'])) ? $q['options'] : null,
                // Guardar escala solo si es tipo escala, con valores por defecto
                'scale_min'     => $q['type'] === 'scale' ? ($q['scale_min'] ?? 1) : null,
                'scale_max'     => $q['type'] === 'scale' ? ($q['scale_max'] ?? 5) : null,
            ]);
        }

        // Redirigir a la lista con mensaje de éxito
        return redirect()->route('admin.surveys.index')->with('success', 'Encuesta creada exitosamente.');
    }

    /**
     * Mostrar formulario para editar una encuesta existente y sus preguntas.
     *
     * @param Survey $survey
     * @return \Illuminate\View\View
     */
    public function edit(Survey $survey)
    {
        // Cargar preguntas relacionadas para edición en la vista
        $survey->load('questions');

        // Obtener todas las carreras para poder modificar la asignación
        $careers = Career::all();

        return view('admin.surveys.edit', compact('survey', 'careers'));
    }

    /**
     * Actualizar encuesta y sus preguntas existentes.
     *
     * @param Request $request
     * @param Survey $survey
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Survey $survey)
    {
        // Filtrar preguntas incompletas (sin texto o tipo)
        $questionsFiltered = array_filter($request->input('questions', []), function ($q) {
            return !empty($q['question_text']) && !empty($q['type']);
        });

        // Actualizar array de preguntas con filtrado para validación
        $request->merge(['questions' => $questionsFiltered]);

        // Validar los datos recibidos
        $this->validateSurvey($request);

        // Actualizar datos principales de la encuesta
        $survey->update([
            'career_id'   => $request->career_id,
            'title'       => $request->title,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'is_active'   => $request->has('is_active'),
        ]);

        // IDs de preguntas actuales en base de datos
        $existingIds = $survey->questions->pluck('id')->toArray();

        // IDs recibidos desde el formulario para identificar qué actualizar o crear
        $receivedIds = [];

        foreach ($request->questions as $q) {
            if (isset($q['id']) && in_array($q['id'], $existingIds)) {
                // Actualizar pregunta existente
                $question = $survey->questions()->find($q['id']);
                $question->update([
                    'question_text' => $q['question_text'],
                    'type'          => $q['type'],
                    'options'       => (in_array($q['type'], ['option', 'checkbox']) && isset($q['options'])) ? $q['options'] : null,
                    'scale_min'     => $q['type'] === 'scale' ? ($q['scale_min'] ?? 1) : null,
                    'scale_max'     => $q['type'] === 'scale' ? ($q['scale_max'] ?? 5) : null,
                ]);

                // Registrar que esta pregunta fue procesada para no eliminarla luego
                $receivedIds[] = $q['id'];
            } else {
                // Crear nueva pregunta si no existe ID o no coincide con existentes
                $survey->questions()->create([
                    'question_text' => $q['question_text'],
                    'type'          => $q['type'],
                    'options'       => in_array($q['type'], ['option', 'checkbox']) ? $q['options'] : null,
                    'scale_min'     => $q['type'] === 'scale' ? ($q['scale_min'] ?? 1) : null,
                    'scale_max'     => $q['type'] === 'scale' ? ($q['scale_max'] ?? 5) : null,
                ]);
            }
        }

        // Determinar preguntas eliminadas (presentes en BD pero no en formulario)
        $questionsToDelete = array_diff($existingIds, $receivedIds);
        if (!empty($questionsToDelete)) {
            // Eliminar preguntas que fueron removidas en la edición
            Question::whereIn('id', $questionsToDelete)->delete();
        }

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.surveys.index')->with('success', 'Encuesta actualizada correctamente.');
    }

    /**
     * Eliminar una encuesta y todas sus relaciones (preguntas).
     *
     * @param Survey $survey
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Survey $survey)
    {
        // Borrar encuesta, las preguntas se eliminan en cascada si está configurado el modelo
        $survey->delete();

        return redirect()->route('admin.surveys.index')->with('success', 'Encuesta eliminada.');
    }

    /**
     * Validar datos de encuesta y sus preguntas para crear o actualizar.
     *
     * @param Request $request
     * @return void
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

    /**
     * Clonar una encuesta con sus preguntas para crear una copia editable.
     *
     * @param Survey $survey
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clone(Survey $survey)
    {
        \DB::beginTransaction();

        try {
            // Replicar encuesta sin guardar para ajustar campos
            $newSurvey = $survey->replicate();

            // Modificar título para indicar copia
            $newSurvey->title = $survey->title . ' (Copia)';
            // Limpiar fechas y desactivar por defecto
            $newSurvey->start_date = null;
            $newSurvey->end_date = null;
            $newSurvey->is_active = false;

            // Guardar nueva encuesta para obtener ID
            $newSurvey->save();

            // Clonar cada pregunta asignándole la nueva encuesta
            foreach ($survey->questions as $question) {
                $newQuestion = $question->replicate();
                $newQuestion->survey_id = $newSurvey->id;
                $newQuestion->save();
            }

            \DB::commit();

            // Redirigir a la edición del nuevo survey con mensaje éxito
            return redirect()->route('admin.surveys.edit', $newSurvey)
                ->with('success', 'Encuesta clonada exitosamente. Puedes modificarla ahora.');
        } catch (\Exception $e) {
            \DB::rollBack();

            // Aquí se podría registrar el error $e->getMessage() para diagnóstico

            return redirect()->route('admin.surveys.index')
                ->with('error', 'Error al clonar la encuesta. Inténtalo nuevamente.');
        }
    }
}
