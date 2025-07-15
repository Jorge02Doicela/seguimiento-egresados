@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-text-primary mb-6">Nuevo Usuario</h1>

        @if ($errors->any())
            <div class="bg-error-lighter text-error px-4 py-3 rounded-lg mb-6 shadow-sm" role="alert">
                <ul class="mb-0 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST"
            class="bg-white p-8 rounded-2xl shadow-primary-lg max-w-2xl mx-auto">
            @csrf

            <div class="mb-5">
                <label class="block text-text-secondary text-sm font-medium mb-1">Nombre</label>
                <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>
                @error('name')
                    <small class="text-error text-xs mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-text-secondary text-sm font-medium mb-1">Correo Electrónico</label>
                <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
                @error('email')
                    <small class="text-error text-xs mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-text-secondary text-sm font-medium mb-1">Contraseña</label>
                <div class="flex">
                    <input type="password" id="password" name="password" class="form-input rounded-r-none" required>
                    <button type="button" class="btn btn-outline border-l-0 rounded-l-none" id="togglePassword">
                        Mostrar
                    </button>
                </div>
                @error('password')
                    <small class="text-error text-xs mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-text-secondary text-sm font-medium mb-1">Confirmar Contraseña</label>
                <div class="flex">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-input rounded-r-none" required>
                    <button type="button" class="btn btn-outline border-l-0 rounded-l-none" id="togglePasswordConfirm">
                        Mostrar
                    </button>
                </div>
                @error('password_confirmation')
                    <small class="text-error text-xs mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-text-secondary text-sm font-medium mb-1">Rol</label>
                <select name="role_id" class="form-select" required>
                    @foreach ($roles as $id => $name)
                        <option value="{{ $id }}" {{ old('role_id') == $id ? 'selected' : '' }}>
                            {{ ucfirst($name) }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <small class="text-error text-xs mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="btn btn-primary px-6 py-3 shadow-primary hover:shadow-primary-dark">Crear</button>
                <a href="{{ route('admin.users.index') }}"
                    class="btn bg-gray-silver text-white hover:bg-gray-slate focus:ring-gray-silver px-6 py-3">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.textContent = type === 'password' ? 'Mostrar' : 'Ocultar';
        });

        const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
        const passwordConfirm = document.querySelector('#password_confirmation');

        togglePasswordConfirm.addEventListener('click', function() {
            const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirm.setAttribute('type', type);
            this.textContent = type === 'password' ? 'Mostrar' : 'Ocultar';
        });
    </script>
@endsection
