@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
    <div class="container py-4">
        <h1>Editar Usuario: {{ $user->name }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-control"
                    value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Campo de selección de rol --}}
            <div class="mb-3">
                <label for="role_id" class="form-label">Rol</label>
                <select name="role_id" id="role_id" class="form-select" required>
                    @foreach ($roles as $id => $name)
                        <option value="{{ $id }}" @selected($id == old('role_id', $userRole))>{{ ucfirst($name) }}</option>
                    @endforeach
                </select>
                @error('role_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña (dejar en blanco para no cambiar)</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" autocomplete="new-password">

                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">Mostrar</button>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        autocomplete="new-password">

                    <button type="button" class="btn btn-outline-secondary" id="togglePasswordConfirm">Mostrar</button>
                </div>
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Guardar Cambios</button>
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
