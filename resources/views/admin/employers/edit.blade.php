@extends('layouts.app')

@section('title', 'Editar Empleador')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Editar Empleador</h1>

        <form action="{{ route('admin.employers.update', $employer) }}" method="POST" class="max-w-xl">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="company_name" class="block font-semibold mb-1">Empresa</label>
                <input type="text" name="company_name" id="company_name"
                    value="{{ old('company_name', $employer->company_name) }}" required
                    class="input input-bordered w-full" />
                @error('company_name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="contact_name" class="block font-semibold mb-1">Contacto</label>
                <input type="text" name="contact_name" id="contact_name"
                    value="{{ old('contact_name', $employer->contact_name) }}" required
                    class="input input-bordered w-full" />
                @error('contact_name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Agrega aquí los demás campos similares -->

            <div class="mb-4">
                <label for="phone" class="block font-semibold mb-1">Teléfono</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $employer->phone) }}"
                    class="input input-bordered w-full" />
                @error('phone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="company_email" class="block font-semibold mb-1">Email Empresa</label>
                <input type="email" name="company_email" id="company_email"
                    value="{{ old('company_email', $employer->company_email) }}" class="input input-bordered w-full" />
                @error('company_email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Continúa con otros campos... -->

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="{{ route('admin.employers.index') }}" class="btn btn-secondary ml-2">Cancelar</a>
        </form>
    </div>
@endsection
