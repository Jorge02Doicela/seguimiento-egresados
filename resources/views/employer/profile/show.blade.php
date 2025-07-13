@extends('layouts.app')

@section('title', 'Mi Perfil - Empleador')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-xl rounded-2xl p-6 md:p-8">
            <h1 class="text-2xl font-bold mb-6 text-primary">Perfil de la Empresa</h1>

            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">

                {{-- Información del empleador --}}
                <div class="w-full">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h2 class="text-sm font-medium text-gray-500">Nombre de la empresa</h2>
                            <p class="text-lg font-semibold">{{ $employer->company_name }}</p>
                        </div>
                        <div>
                            <h2 class="text-sm font-medium text-gray-500">Representante</h2>
                            <p class="text-lg font-semibold">{{ $employer->contact_name }}</p>
                        </div>
                        <div>
                            <h2 class="text-sm font-medium text-gray-500">Correo de empresa</h2>
                            <p>{{ $employer->company_email ?? 'No especificado' }}</p>
                        </div>
                        <div>
                            <h2 class="text-sm font-medium text-gray-500">Teléfono</h2>
                            <p>{{ $employer->phone ?? 'No especificado' }}</p>
                        </div>
                        <div>
                            <h2 class="text-sm font-medium text-gray-500">Sitio web</h2>
                            @if ($employer->website)
                                <a href="{{ $employer->website }}" class="text-blue-600 hover:underline" target="_blank">
                                    {{ $employer->website }}
                                </a>
                            @else
                                <p>No especificado</p>
                            @endif
                        </div>
                        <div>
                            <h2 class="text-sm font-medium text-gray-500">Sector</h2>
                            <p>{{ $employer->sector ?? 'No especificado' }}</p>
                        </div>
                        <div>
                            <h2 class="text-sm font-medium text-gray-500">País</h2>
                            <p>{{ $employer->country ?? 'No especificado' }}</p>
                        </div>
                        <div>
                            <h2 class="text-sm font-medium text-gray-500">Ciudad</h2>
                            <p>{{ $employer->city ?? 'No especificado' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <h2 class="text-sm font-medium text-gray-500">Dirección</h2>
                            <p>{{ $employer->address ?? 'No especificado' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botón para editar --}}
            <div class="mt-8 text-right">
                <a href="{{ route('employer.profile.edit') }}"
                    class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-lg shadow-md transition">
                    <i class="bi bi-pencil-square mr-2"></i> Editar Perfil
                </a>
            </div>
        </div>
    </div>
@endsection
