@extends('layouts.app')

@section('title', 'Buscar Egresados')

@section('content')
    <div class="container mx-auto p-4 md:p-8">
        <h2 class="text-3xl font-headings text-text-primary mb-6">Buscar Egresados</h2>

        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 p-6 bg-white shadow-md rounded-lg">
            <div class="col-span-1">
                <label for="cohort_year" class="block text-sm font-medium text-text-secondary mb-1">Cohorte</label>
                <select id="cohort_year" name="cohort_year" class="form-select">
                    <option value="">-- Todos --</option>
                    @foreach ($cohortYears as $year)
                        <option value="{{ $year }}"
                            {{ isset($filters['cohort_year']) && $filters['cohort_year'] == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-1">
                <label for="gender" class="block text-sm font-medium text-text-secondary mb-1">Género</label>
                <select id="gender" name="gender" class="form-select">
                    <option value="">-- Todos --</option>
                    <option value="M" {{ ($filters['gender'] ?? '') === 'M' ? 'selected' : '' }}>Masculino</option>
                    <option value="F" {{ ($filters['gender'] ?? '') === 'F' ? 'selected' : '' }}>Femenino</option>
                    <option value="Otro" {{ ($filters['gender'] ?? '') === 'Otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
            <div class="col-span-1">
                <label for="sector" class="block text-sm font-medium text-text-secondary mb-1">Sector laboral</label>
                <select id="sector" name="sector" class="form-select">
                    <option value="">-- Todos --</option>
                    <option value="privado" {{ ($filters['sector'] ?? '') === 'privado' ? 'selected' : '' }}>Privado
                    </option>
                    <option value="público" {{ ($filters['sector'] ?? '') === 'público' ? 'selected' : '' }}>Público
                    </option>
                    <option value="freelance" {{ ($filters['sector'] ?? '') === 'freelance' ? 'selected' : '' }}>Freelance
                    </option>
                </select>
            </div>
            <div class="col-span-1 flex items-end">
                <button type="submit" class="btn btn-primary w-full md:w-auto">Buscar</button>
            </div>
        </form>

        <p class="text-text-secondary mb-4">Mostrando <span
                class="font-semibold text-primary">{{ $graduates->total() }}</span> resultados</p>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-border-primary">
                <thead class="bg-gray-lighter">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">Nombre
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">Cohorte
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">Género
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">Empresa
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">Puesto
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">Sector
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-border-primary">
                    @forelse($graduates as $grad)
                        <tr class="hover:bg-gray-lightest transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-text-primary">
                                {{ $grad->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-secondary">{{ $grad->cohort_year }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-secondary">{{ $grad->gender }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-secondary">{{ $grad->company }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-secondary">{{ $grad->position }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-secondary">
                                @if ($grad->sector === 'privado')
                                    <span class="badge badge-success">Privado</span>
                                @elseif($grad->sector === 'público')
                                    <span class="badge badge-primary bg-primary-lightest text-primary">Público</span>
                                @elseif($grad->sector === 'freelance')
                                    <span class="badge badge-warning">Freelance</span>
                                @else
                                    <span class="badge">{{ $grad->sector }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-sm text-text-muted">No se
                                encontraron egresados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            {{ $graduates->withQueryString()->links('pagination::tailwind') }} {{-- Assuming you'll publish Tailwind pagination views --}}
        </div>
    </div>
@endsection
