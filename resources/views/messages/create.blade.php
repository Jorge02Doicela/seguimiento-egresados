@extends('layouts.app')

@section('title', 'Nuevo Mensaje')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-text-primary mb-6">Enviar Nuevo Mensaje</h1>

        @if ($errors->any())
            <div class="bg-error-lighter text-error px-4 py-3 rounded-lg mb-6 shadow-sm" role="alert">
                <strong class="font-semibold">Hay errores en el formulario:</strong>
                <ul class="mt-2 mb-0 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data" novalidate
            class="bg-white p-8 rounded-2xl shadow-primary-lg max-w-xl mx-auto">
            @csrf

            <div class="mb-5">
                <label for="receiver_id" class="block text-text-secondary text-sm font-medium mb-1">Destinatario</label>
                <select name="receiver_id" id="receiver_id" class="form-select" required>
                    <option value="" selected disabled>Selecciona un usuario</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('receiver_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ implode(', ', $user->roles->pluck('name')->toArray()) }})
                        </option>
                    @endforeach
                </select>
                @error('receiver_id')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="content" class="block text-text-secondary text-sm font-medium mb-1">Mensaje</label>
                <textarea name="content" id="content" rows="5" class="form-textarea" maxlength="1000" required>{{ old('content') }}</textarea>
                <div class="text-text-muted text-xs mt-1">Máximo 1000 caracteres.</div>
                @error('content')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn btn-success px-6 py-3 shadow-success hover:shadow-success-dark">
                    <i class="bi bi-send-fill mr-2"></i> Enviar Mensaje
                </button>
                <a href="{{ route('messages.inbox') }}"
                    class="btn bg-gray-silver text-white hover:bg-gray-slate focus:ring-gray-silver px-6 py-3">Cancelar</a>
            </div>
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
