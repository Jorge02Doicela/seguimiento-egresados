@extends('layouts.app')

@section('title', 'Editar Perfil - Empleador')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-xl rounded-2xl p-6 md:p-8">
            <h1 class="text-2xl font-bold mb-6 text-primary">Editar Perfil de la Empresa</h1>

            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('employer.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Company Name --}}
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700">Nombre de la
                            empresa</label>
                        <input type="text" id="company_name" name="company_name"
                            value="{{ old('company_name', $employer->company_name) }}"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-primary focus:border-primary"
                            required>
                    </div>

                    {{-- Contact Name --}}
                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-gray-700">Nombre del
                            representante</label>
                        <input type="text" id="contact_name" name="contact_name"
                            value="{{ old('contact_name', $employer->contact_name) }}"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-primary focus:border-primary"
                            required>
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $employer->phone) }}"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-primary focus:border-primary">
                    </div>

                    {{-- Company Email --}}
                    <div>
                        <label for="company_email" class="block text-sm font-medium text-gray-700">Correo de empresa</label>
                        <input type="email" id="company_email" name="company_email"
                            value="{{ old('company_email', $employer->company_email) }}"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-primary focus:border-primary">
                    </div>

                    {{-- Website --}}
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700">Sitio web</label>
                        <input type="url" id="website" name="website" value="{{ old('website', $employer->website) }}"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-primary focus:border-primary">
                    </div>

                    {{-- Sector --}}
                    <div>
                        <label for="sector" class="block text-sm font-medium text-gray-700">Sector</label>
                        <input type="text" id="sector" name="sector" value="{{ old('sector', $employer->sector) }}"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-primary focus:border-primary">
                    </div>

                    {{-- Country --}}
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700">País</label>
                        <input type="text" id="country" name="country" value="{{ old('country', $employer->country) }}"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-primary focus:border-primary">
                    </div>

                    {{-- City --}}
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">Ciudad</label>
                        <input type="text" id="city" name="city" value="{{ old('city', $employer->city) }}"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-primary focus:border-primary">
                    </div>

                    {{-- Address (span full width) --}}
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700">Dirección</label>
                        <input type="text" id="address" name="address"
                            value="{{ old('address', $employer->address) }}"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-primary focus:border-primary">
                    </div>
                </div>



                {{-- Botón guardar --}}
                <div class="text-right mt-6">
                    <button type="submit"
                        class="px-6 py-2 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg shadow-md transition">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
