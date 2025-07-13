@extends('layouts.admin') {{-- O tu layout admin principal --}}

@section('title', 'Gestión de Empleadores')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Gestión de Empleadores</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white border rounded shadow">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Empresa</th>
                    <th class="px-4 py-2 border">Contacto</th>
                    <th class="px-4 py-2 border">Usuario (email)</th>
                    <th class="px-4 py-2 border">Estado</th>
                    <th class="px-4 py-2 border">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($employers as $employer)
                    <tr>
                        <td class="border px-4 py-2">{{ $employer->id }}</td>
                        <td class="border px-4 py-2">{{ $employer->company_name }}</td>
                        <td class="border px-4 py-2">{{ $employer->contact_name }}</td>
                        <td class="border px-4 py-2">{{ $employer->user->email ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">
                            @if ($employer->is_verified)
                                <span class="text-green-600 font-semibold">Verificado</span>
                            @else
                                <span class="text-red-600 font-semibold">Pendiente</span>
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2 space-x-2">

                            <!-- Ver detalles -->
                            <a href="{{ route('admin.employers.show', $employer) }}" class="btn btn-info btn-sm"
                                title="Ver detalles">
                                <i class="bi bi-eye"></i>
                            </a>

                            <!-- Editar -->
                            <a href="{{ route('admin.employers.edit', $employer) }}" class="btn btn-warning btn-sm"
                                title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <!-- Verificar / Desverificar -->
                            <form action="{{ route('admin.employers.verify', $employer) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm"
                                    onclick="return confirm('¿Confirmas cambiar el estado de verificación?')"
                                    title="Cambiar estado verificación">
                                    @if ($employer->is_verified)
                                        <i class="bi bi-check2-circle"></i>
                                    @else
                                        <i class="bi bi-x-circle"></i>
                                    @endif
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4">No hay empleadores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $employers->links() }}
        </div>
    </div>
@endsection
