@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Nuevo Usuario</h1>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control" required>
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                        Mostrar
                    </button>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Confirmar Contraseña</label>
                <div class="input-group">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                        required>
                    <button type="button" class="btn btn-outline-secondary" id="togglePasswordConfirm">
                        Mostrar
                    </button>
                </div>
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="role_id" class="form-select" required>
                    @foreach ($roles as $id => $name)
                        <option value="{{ $id }}" {{ old('role_id') == $id ? 'selected' : '' }}>
                            {{ ucfirst($name) }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button class="btn btn-primary">Crear</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
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
