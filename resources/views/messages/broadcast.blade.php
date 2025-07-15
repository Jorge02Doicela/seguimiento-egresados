@extends('layouts.app')

@section('title', 'Mensaje Masivo')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-text-primary mb-6">Enviar Mensaje Masivo</h1>

        @if ($errors->any())
            <div class="bg-error-lighter text-error px-4 py-3 rounded-lg mb-6 shadow-sm" role="alert">
                <strong class="font-semibold">Corrige los errores:</strong>
                <ul class="mt-2 mb-0 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.messages.broadcast') }}" method="POST"
            class="bg-white p-8 rounded-2xl shadow-primary-lg max-w-xl mx-auto">
            @csrf

            <div class="mb-6">
                <label for="content" class="block text-text-secondary text-sm font-medium mb-1">Mensaje</label>
                <textarea name="content" id="content" rows="6" class="form-textarea" maxlength="1000">{{ old('content') }}</textarea>
                <div class="text-text-muted text-xs mt-1">Este mensaje será enviado a todos los egresados y empleadores.
                </div>
                @error('content')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 flex items-center">
                <input class="form-checkbox" type="checkbox" name="force_update" id="force_update"
                    {{ old('force_update') ? 'checked' : '' }} value="1">
                <label class="ml-2 text-text-secondary text-sm" for="force_update">
                    Solicitar actualización de perfil (se añadirá un mensaje extra)
                </label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn btn-success px-6 py-3 shadow-success hover:shadow-success-dark">
                    <i class="bi bi-megaphone-fill mr-2"></i> Enviar Mensaje Masivo
                </button>
                <a href="{{ route('messages.inbox') }}"
                    class="btn bg-gray-silver text-white hover:bg-gray-slate focus:ring-gray-silver px-6 py-3">Cancelar</a>
            </div>
        </form>
    </div>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('force_update');
            const textarea = document.getElementById('content');
            const mensajeExtra = "\n\n🔴 Mensaje importante de actualización de datos";

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
