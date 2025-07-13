<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Mostrar listado paginado de usuarios, con opción a filtrar
     * por nombre/email y por rol asignado.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $roleFilter = $request->input('role_id');

        $users = User::query()
            ->when($search, function ($query, $search) {
                // Filtrar usuarios cuyo nombre o email contengan el término de búsqueda
                $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->when($roleFilter, function ($query, $roleFilter) {
                // Filtrar usuarios que tengan asignado un rol específico
                $query->whereHas('roles', function ($q) use ($roleFilter) {
                    $q->where('id', $roleFilter);
                });
            })
            ->paginate(15); // Paginación para evitar cargar demasiados registros

        $roles = Role::all(); // Obtener todos los roles para filtro en vista

        return view('admin.users.index', compact('users', 'search', 'roles', 'roleFilter'));
    }

    /**
     * Mostrar formulario para crear un nuevo usuario.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Obtener lista de roles con formato [id => nombre] para selector
        $roles = Role::pluck('name', 'id');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Validar y almacenar un nuevo usuario en la base de datos.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $messages = [
            'password.regex' => 'La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una minúscula y un número.',
        ];

        // Validación de campos con reglas estrictas para contraseña segura
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed', // Confirma que el campo password_confirmation sea igual
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', // Regex para validar mayúscula, minúscula y número
            ],
            'role_id' => ['required', 'exists:roles,id'],
        ], $messages);

        // Crear usuario con contraseña hasheada
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Asignar rol al usuario recién creado
        $role = Role::findOrFail($data['role_id']);
        $user->assignRole($role->name);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Mostrar formulario para editar un usuario existente.
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        // Obtener roles para selector en formulario
        $roles = Role::pluck('name', 'id');

        // Obtener primer rol asignado al usuario (se asume 1 rol por usuario)
        $userRole = $user->roles->pluck('id')->first();

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Validar y actualizar datos de usuario existente.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $messages = [
            'password.regex' => 'La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una minúscula y un número.',
        ];

        // Validar datos; contraseña es opcional y solo se actualiza si se envía
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id), // Ignorar email actual para evitar error de unicidad
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
            'role_id' => ['required', 'exists:roles,id'],
        ], $messages);

        // Actualizar campos básicos
        $user->name = $data['name'];
        $user->email = $data['email'];

        // Actualizar contraseña solo si se envió y validó
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        // Sincronizar rol (remplaza roles previos)
        $role = Role::findOrFail($data['role_id']);
        $user->syncRoles([$role->name]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario de la base de datos.
     * Evita que un usuario se elimine a sí mismo para no perder acceso.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }

    /**
     * Alternar estado de bloqueo del usuario (bloqueado/desbloqueado).
     * Previene bloqueo de sí mismo para evitar quedar sin acceso.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleBlock(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'No puedes bloquear tu propio usuario.');
        }

        // Cambiar el estado booleano de bloqueo
        $user->is_blocked = !$user->is_blocked;
        $user->save();

        return redirect()->back()->with('success', 'Estado de bloqueo actualizado correctamente.');
    }
}
