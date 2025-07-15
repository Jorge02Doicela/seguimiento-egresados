@extends('layouts.app')

@section('title', 'Detalles del Empleador')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-text-primary mb-6">Detalles del Empleador</h1>

        <div class="bg-white shadow-md rounded-2xl overflow-hidden mb-8">
            <table class="min-w-full leading-normal">
                <tbody>
                    <tr class="border-b border-gray-lighter">
                        <th class="px-5 py-4 text-left text-sm font-semibold text-text-muted bg-gray-light w-1/3">Empresa
                        </th>
                        <td class="px-5 py-4 text-sm text-text-secondary">{{ $employer->company_name }}</td>
                    </tr>
                    <tr class="border-b border-gray-lighter">
                        <th class="px-5 py-4 text-left text-sm font-semibold text-text-muted bg-gray-light w-1/3">Teléfono
                        </th>
                        <td class="px-5 py-4 text-sm text-text-secondary">{{ $employer->phone ?? '-' }}</td>
                    </tr>
                    <tr class="border-b border-gray-lighter">
                        <th class="px-5 py-4 text-left text-sm font-semibold text-text-muted bg-gray-light w-1/3">Dirección
                        </th>
                        <td class="px-5 py-4 text-sm text-text-secondary">{{ $employer->address ?? '-' }}</td>
                    </tr>
                    <tr class="border-b border-gray-lighter">
                        <th class="px-5 py-4 text-left text-sm font-semibold text-text-muted bg-gray-light w-1/3">Sitio Web
                        </th>
                        <td class="px-5 py-4 text-sm text-text-secondary">
                            @if ($employer->website)
                                <a href="{{ $employer->website }}" target="_blank"
                                    class="text-primary hover:text-primary-dark transition-colors duration-300">{{ $employer->website }}</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr class="border-b border-gray-lighter">
                        <th class="px-5 py-4 text-left text-sm font-semibold text-text-muted bg-gray-light w-1/3">Sector
                        </th>
                        <td class="px-5 py-4 text-sm text-text-secondary">{{ $employer->sector ?? '-' }}</td>
                    </tr>
                    <tr class="border-b border-gray-lighter">
                        <th class="px-5 py-4 text-left text-sm font-semibold text-text-muted bg-gray-light w-1/3">Ciudad
                        </th>
                        <td class="px-5 py-4 text-sm text-text-secondary">{{ $employer->city ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="px-5 py-4 text-left text-sm font-semibold text-text-muted bg-gray-light w-1/3">Estado
                        </th>
                        <td class="px-5 py-4 text-sm text-text-secondary">
                            @if ($employer->is_verified)
                                <span class="badge badge-success">Verificado</span>
                            @else
                                <span class="badge badge-warning">No verificado</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <a href="{{ route('admin.employers.index') }}"
            class="btn bg-gray-silver text-white hover:bg-gray-slate focus:ring-gray-silver">Volver al listado</a>
    </div>
@endsection
