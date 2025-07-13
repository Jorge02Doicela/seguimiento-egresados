<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Mostrar perfil del empleador autenticado
    public function show()
    {
        $employer = Auth::user()->employer;
        return view('employer.profile.show', compact('employer'));
    }

    // Mostrar formulario para editar perfil
    public function edit()
    {
        $employer = Auth::user()->employer;
        return view('employer.profile.edit', compact('employer'));
    }

    // Actualizar perfil
    public function update(Request $request)
    {
        $employer = Auth::user()->employer;

        // Validar datos recibidos
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'sector' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);

        // Actualizar campos básicos excepto logo_path
        $employer->update($validatedData);

        // Subir logo si se envió archivo
        if ($request->hasFile('logo')) {
            // Eliminar logo previo si existe (agregamos 'public/' para borrar correctamente)
            if ($employer->logo_path) {
                Storage::delete('public/' . $employer->logo_path);
            }
            // Guardar nuevo logo (ruta con prefijo 'public/')
            $path = $request->file('logo')->store('public/employer_logos');

            // Guardar solo la ruta relativa sin 'public/'
            $relativePath = str_replace('public/', '', $path);
            $employer->logo_path = $relativePath;
            $employer->save();
        }

        return redirect()->route('employer.profile.show')->with('success', 'Perfil actualizado correctamente.');
    }
}
