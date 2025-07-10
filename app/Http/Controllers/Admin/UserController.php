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
     * Mostrar listado de usuarios con filtro por búsqueda y rol.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $roleFilter = $request->input('role_id');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->when($roleFilter, function ($query, $roleFilter) {
                $query->whereHas('roles', function ($q) use ($roleFilter) {
                    $q->where('id', $roleFilter);
                });
            })
            ->paginate(15);

        $roles = Role::all();

        return view('admin.users.index', compact('users', 'search', 'roles', 'roleFilter'));
    }

    /**
     * Mostrar formulario de creación de usuario.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id');
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Almacenar un nuevo usuario.
     */
    public function store(Request $request)
    {
        $messages = [
            'password.regex' => 'La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una minúscula y un número.',
        ];

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
            'role_id' => ['required', 'exists:roles,id'],
        ], $messages);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $role = Role::findOrFail($data['role_id']);
        $user->assignRole($role->name);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Mostrar formulario de edición de usuario.
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'id');
        $userRole = $user->roles->pluck('id')->first(); // Asumimos 1 rol por usuario

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Actualizar un usuario.
     */
    public function update(Request $request, User $user)
    {
        $messages = [
            'password.regex' => 'La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una minúscula y un número.',
        ];

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
            'role_id' => ['required', 'exists:roles,id'],
        ], $messages);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        $role = Role::findOrFail($data['role_id']);
        $user->syncRoles([$role->name]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar un usuario.
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
     * Alternar bloqueo de usuario.
     */
    public function toggleBlock(User $user)
    {
        // Evitar que un admin se bloquee a sí mismo (opcional)
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'No puedes bloquear tu propio usuario.');
        }

        $user->is_blocked = !$user->is_blocked;
        $user->save();

        return redirect()->back()->with('success', 'Estado de bloqueo actualizado correctamente.');
    }
}
