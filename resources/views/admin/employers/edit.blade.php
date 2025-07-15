@extends('layouts.app')

@section('title', 'Editar Empleador')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-text-primary mb-6">Editar Empleador</h1>

        <form action="{{ route('admin.employers.update', $employer) }}" method="POST"
            class="bg-white p-8 rounded-2xl shadow-primary-lg max-w-2xl mx-auto">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="company_name" class="block text-text-secondary text-sm font-medium mb-1">Empresa</label>
                <input type="text" name="company_name" id="company_name"
                    value="{{ old('company_name', $employer->company_name) }}" required class="form-input" />
                @error('company_name')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="phone" class="block text-text-secondary text-sm font-medium mb-1">Teléfono</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $employer->phone) }}"
                    class="form-input" />
                @error('phone')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="address" class="block text-text-secondary text-sm font-medium mb-1">Dirección</label>
                <input type="text" name="address" id="address" value="{{ old('address', $employer->address) }}"
                    class="form-input" />
                @error('address')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="website" class="block text-text-secondary text-sm font-medium mb-1">Sitio Web</label>
                <input type="url" name="website" id="website" value="{{ old('website', $employer->website) }}"
                    class="form-input" />
                @error('website')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="sector" class="block text-text-secondary text-sm font-medium mb-1">Sector</label>
                <input type="text" name="sector" id="sector" value="{{ old('sector', $employer->sector) }}"
                    class="form-input" />
                @error('sector')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="city" class="block text-text-secondary text-sm font-medium mb-1">Ciudad</label>
                <input type="text" name="city" id="city" value="{{ old('city', $employer->city) }}"
                    class="form-input" />
                @error('city')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn btn-primary px-6 py-3 shadow-primary hover:shadow-primary-dark">Guardar
                    cambios</button>
                <a href="{{ route('admin.employers.index') }}"
                    class="btn bg-gray-silver text-white hover:bg-gray-slate focus:ring-gray-silver px-6 py-3">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
