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
                <label for="phone" class="block font-semibold mb-1">Teléfono</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $employer->phone) }}"
                    class="input input-bordered w-full" />
                @error('phone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="address" class="block font-semibold mb-1">Dirección</label>
                <input type="text" name="address" id="address" value="{{ old('address', $employer->address) }}"
                    class="input input-bordered w-full" />
                @error('address')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="website" class="block font-semibold mb-1">Sitio Web</label>
                <input type="url" name="website" id="website" value="{{ old('website', $employer->website) }}"
                    class="input input-bordered w-full" />
                @error('website')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="sector" class="block font-semibold mb-1">Sector</label>
                <input type="text" name="sector" id="sector" value="{{ old('sector', $employer->sector) }}"
                    class="input input-bordered w-full" />
                @error('sector')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="country" class="block font-semibold mb-1">País</label>
                <input type="text" name="country" id="country" value="{{ old('country', $employer->country) }}"
                    class="input input-bordered w-full" />
                @error('country')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="city" class="block font-semibold mb-1">Ciudad</label>
                <input type="text" name="city" id="city" value="{{ old('city', $employer->city) }}"
                    class="input input-bordered w-full" />
                @error('city')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="{{ route('admin.employers.index') }}" class="btn btn-secondary ml-2">Cancelar</a>
        </form>
    </div>
@endsection
