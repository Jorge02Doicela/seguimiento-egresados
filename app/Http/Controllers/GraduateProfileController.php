<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Graduate;
use App\Models\Skill;
use App\Models\Career;

class GraduateProfileController extends Controller
{
    /**
     * Muestra el perfil del egresado autenticado.
     */
    public function show()
    {
        $graduate = Graduate::with('skills')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('graduate.profile.show', compact('graduate'));
    }

    /**
     * Muestra el formulario de edición del perfil.
     */
    public function edit()
    {
        $graduate = Graduate::with('skills')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $allSkills = Skill::all();
        $careers = Career::all();

        return view('graduate.profile.edit', compact('graduate', 'allSkills', 'careers'));
    }

    /**
     * Actualiza el perfil del egresado con validaciones.
     */
    public function update(Request $request)
    {
        $graduate = Graduate::where('user_id', Auth::id())->firstOrFail();

        // Validaciones incluyendo los campos position y non_tech_position
        $validated = $request->validate([
            'cohort_year' => 'required|integer|min:1900|max:' . date('Y'),
            'gender' => 'required|in:M,F,Otro',
            'is_working' => 'required|boolean',
            'company' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'portfolio_url' => 'nullable|url|max:255',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'career_id' => 'nullable|exists:careers,id',

            // Validar position y non_tech_position
            'position' => 'nullable|string|max:100',
            'non_tech_position' => 'nullable|string|max:100',
        ]);

        // Guardar los campos position y non_tech_position directamente
        $graduate->position = $validated['position'] ?? null;
        $graduate->non_tech_position = $validated['non_tech_position'] ?? null;

        // El resto de campos masivos
        $graduate->cohort_year = $validated['cohort_year'];
        $graduate->gender = $validated['gender'];
        $graduate->is_working = $validated['is_working'];
        $graduate->company = $validated['company'] ?? null;
        $graduate->salary = $validated['salary'] ?? null;
        $graduate->portfolio_url = $validated['portfolio_url'] ?? null;
        $graduate->country = $validated['country'] ?? null;
        $graduate->city = $validated['city'] ?? null;
        $graduate->career_id = $validated['career_id'] ?? null;

        // Manejo del archivo CV
        if ($request->hasFile('cv')) {
            if ($graduate->cv_path && Storage::disk('public')->exists($graduate->cv_path)) {
                Storage::disk('public')->delete($graduate->cv_path);
            }

            $path = $request->file('cv')->store('cvs', 'public');
            $graduate->cv_path = $path;
        }

        $graduate->save();

        return redirect()
            ->route('graduate.profile.show')
            ->with('success', 'Perfil actualizado correctamente.');
    }



    /**
     * Agrega una habilidad al egresado.
     */
    public function addSkill(Request $request)
    {
        $request->validate([
            'skill_id' => 'required|exists:skills,id',
        ]);

        $graduate = Graduate::where('user_id', Auth::id())->firstOrFail();

        $graduate->skills()->syncWithoutDetaching($request->skill_id);

        return back()->with('success', 'Habilidad agregada.');
    }

    /**
     * Elimina una habilidad del egresado.
     */
    public function removeSkill(Request $request)
    {
        $request->validate([
            'skill_id' => 'required|exists:skills,id',
        ]);

        $graduate = Graduate::where('user_id', Auth::id())->firstOrFail();

        $graduate->skills()->detach($request->skill_id);

        return back()->with('success', 'Habilidad eliminada.');
    }
}
