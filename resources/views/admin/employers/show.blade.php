@extends('layouts.app')

@section('title', 'Detalles del Empleador')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Detalles del Empleador</h1>

        <table class="table-auto border-collapse border border-gray-400 w-full">
            <tbody>
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Empresa</th>
                    <td class="border border-gray-300 px-4 py-2">{{ $employer->company_name }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Teléfono</th>
                    <td class="border border-gray-300 px-4 py-2">{{ $employer->phone ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Dirección</th>
                    <td class="border border-gray-300 px-4 py-2">{{ $employer->address ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Sitio Web</th>
                    <td class="border border-gray-300 px-4 py-2">{{ $employer->website ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Sector</th>
                    <td class="border border-gray-300 px-4 py-2">{{ $employer->sector ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">País</th>
                    <td class="border border-gray-300 px-4 py-2">{{ $employer->country ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Ciudad</th>
                    <td class="border border-gray-300 px-4 py-2">{{ $employer->city ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Estado</th>
                    <td class="border border-gray-300 px-4 py-2">
                        @if ($employer->is_verified)
                            <span class="text-green-600 font-semibold">Verificado</span>
                        @else
                            <span class="text-red-600 font-semibold">No verificado</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <a href="{{ route('admin.employers.index') }}" class="btn btn-secondary mt-4">Volver al listado</a>
    </div>
@endsection
