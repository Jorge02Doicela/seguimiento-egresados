<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    /**
     * Mostrar la lista paginada de empleadores con su usuario relacionado.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $employers = Employer::with('user')->paginate(15);
        return view('admin.employers.index', compact('employers'));
    }

    /**
     * Mostrar información completa de un empleador específico.
     *
     * @param  Employer  $employer
     * @return \Illuminate\View\View
     */
    public function show(Employer $employer)
    {
        return view('admin.employers.show', compact('employer'));
    }

    /**
     * Mostrar formulario para editar los datos de un empleador.
     *
     * @param  Employer  $employer
     * @return \Illuminate\View\View
     */
    public function edit(Employer $employer)
    {
        return view('admin.employers.edit', compact('employer'));
    }

    /**
     * Actualizar los datos del empleador validando el formulario.
     *
     * @param  Request   $request
     * @param  Employer  $employer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Employer $employer)
    {
        // Validación de campos con regla unique ignorando el registro actual para tax_id
        $data = $request->validate([
            'company_name'    => 'required|string|max:255',
            'contact_name'    => 'required|string|max:255',
            'phone'          => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:255',
            'company_email'  => 'nullable|email|max:255',
            'company_phone'  => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:255',
            'website'        => 'nullable|url|max:255',
            'sector'         => 'nullable|string|max:100',
            'country'        => 'nullable|string|max:100',
            'city'           => 'nullable|string|max:100',
            'tax_id'         => 'nullable|string|max:100|unique:employers,tax_id,' . $employer->id,
        ]);

        // Actualizar datos en la base de datos
        $employer->update($data);

        // Redireccionar a la lista con mensaje de éxito
        return redirect()->route('admin.employers.index')
            ->with('success', 'Empleador actualizado correctamente.');
    }

    /**
     * Alternar el estado de verificación del empleador (toggle).
     *
     * @param  Employer  $employer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Employer $employer)
    {
        // Cambiar el estado booleano is_verified al opuesto
        $employer->is_verified = !$employer->is_verified;
        $employer->save();

        $estado = $employer->is_verified ? 'verificado' : 'no verificado';

        // Redireccionar con mensaje de confirmación del cambio
        return redirect()->route('admin.employers.index')
            ->with('success', "Empleador {$estado} correctamente.");
    }
}
