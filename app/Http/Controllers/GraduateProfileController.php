<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Graduate;
use App\Models\Skill;

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

        return view('graduate.profile.edit', compact('graduate', 'allSkills'));
    }

    /**
     * Actualiza el perfil del egresado con validaciones.
     */
    public function update(Request $request)
    {
        $graduate = Graduate::where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'cohort_year' => 'required|integer|min:1900|max:' . date('Y'),
            'gender' => 'required|in:M,F,Otro',
            'is_working' => 'required|boolean',
            'company' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'sector' => 'nullable|in:privado,público,freelance',
            'portfolio_url' => 'nullable|url|max:255',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);

        $graduate->fill($validated);

        if ($request->hasFile('cv')) {
            // Borra el archivo anterior si existe
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
