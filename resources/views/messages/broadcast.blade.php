@extends('layouts.app')

@section('title', 'Mensaje Masivo')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Enviar Mensaje Masivo</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Corrige los errores:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.messages.broadcast') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="content" class="form-label">Mensaje</label>
                <textarea name="content" id="content" rows="6" class="form-control" maxlength="1000">{{ old('content') }}</textarea>
                <div class="form-text">Este mensaje será enviado a todos los egresados y empleadores.</div>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="force_update" id="force_update"
                    {{ old('force_update') ? 'checked' : '' }} value="1">
                <label class="form-check-label" for="force_update">
                    Solicitar actualización de perfil (se añadirá un mensaje extra)
                </label>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-megaphone-fill"></i> Enviar Mensaje Masivo
            </button>
            <a href="{{ route('messages.inbox') }}" class="btn btn-secondary ms-2">Cancelar</a>
        </form>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkbox = document.getElementById('force_update');
                const textarea = document.getElementById('content');
                const mensajeExtra =
                    "\n\n🔴 Mensaje importante de actualización de datos";

                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        if (!textarea.value.includes(mensajeExtra.trim())) {
                            textarea.value += mensajeExtra;
                        }
                    } else {
                        textarea.value = textarea.value.replace(mensajeExtra, '');
                    }
                });
            });
        </script>
    @endsection


@endsection
