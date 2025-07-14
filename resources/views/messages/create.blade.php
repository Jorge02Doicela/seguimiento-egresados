@extends('layouts.app')

@section('title', 'Nuevo Mensaje')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Enviar Nuevo Mensaje</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Hay errores en el formulario:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="mb-3">
                <label for="receiver_id" class="form-label">Destinatario</label>
                <select name="receiver_id" id="receiver_id" class="form-select" required>
                    <option value="" selected disabled>Selecciona un usuario</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('receiver_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ implode(', ', $user->roles->pluck('name')->toArray()) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Mensaje</label>
                <textarea name="content" id="content" rows="5" class="form-control" maxlength="1000" required>{{ old('content') }}</textarea>
                <div class="form-text">Máximo 1000 caracteres.</div>
            </div>



            <button type="submit" class="btn btn-success">
                <i class="bi bi-send-fill"></i> Enviar Mensaje
            </button>
            <a href="{{ route('messages.inbox') }}" class="btn btn-secondary ms-2">Cancelar</a>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect("#receiver_id", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "Buscar destinatario...",
                loadThrottle: 300,
                maxOptions: 100,
                plugins: ['dropdown_input']
            });
        });
    </script>
@endsection
