@extends('layouts.app')

@section('title', 'Buscar Egresados')

@section('content')
    <div class="container mx-auto p-4 md:p-8">
        <h2 class="text-3xl font-headings text-text-primary mb-6">Buscar Egresados</h2>

        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8 p-6 bg-white shadow-md rounded-lg"
            id="filterForm">
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
                <label for="area_laboral" class="block text-sm font-medium text-text-secondary mb-1">Área Laboral</label>
                <select id="area_laboral" name="area_laboral" class="form-select">
                    <option value="">-- Todos --</option>
                    <option value="tecnologia" {{ ($filters['area_laboral'] ?? '') === 'tecnologia' ? 'selected' : '' }}>
                        Tecnología</option>
                    <option value="otros" {{ ($filters['area_laboral'] ?? '') === 'otros' ? 'selected' : '' }}>Otros
                    </option>
                </select>
            </div>

            <div class="col-span-1" id="sector_tecnologia_div" style="display: none;">
                <label for="sector_tecnologia" class="block text-sm font-medium text-text-secondary mb-1">Sector
                    Tecnología</label>
                <select id="sector_tecnologia" name="sector_tecnologia" class="form-select">
                    <option value="">-- Todos --</option>
                    <option value="desarrollo_software"
                        {{ ($filters['sector_tecnologia'] ?? '') === 'desarrollo_software' ? 'selected' : '' }}>Desarrollo
                        de Software</option>
                    <option value="infraestructura"
                        {{ ($filters['sector_tecnologia'] ?? '') === 'infraestructura' ? 'selected' : '' }}>Infraestructura
                    </option>
                    <option value="analisis_datos"
                        {{ ($filters['sector_tecnologia'] ?? '') === 'analisis_datos' ? 'selected' : '' }}>Análisis de
                        Datos</option>
                    <option value="seguridad_informatica"
                        {{ ($filters['sector_tecnologia'] ?? '') === 'seguridad_informatica' ? 'selected' : '' }}>Seguridad
                        Informática</option>
                </select>
            </div>

            <div class="col-span-1" id="sector_otros_div" style="display: none;">
                <label for="sector_otros" class="block text-sm font-medium text-text-secondary mb-1">Sector Otros</label>
                <select id="sector_otros" name="sector_otros" class="form-select">
                    <option value="">-- Todos --</option>
                    <option value="vendedor" {{ ($filters['sector_otros'] ?? '') === 'vendedor' ? 'selected' : '' }}>
                        Vendedor</option>
                    <option value="albanil" {{ ($filters['sector_otros'] ?? '') === 'albanil' ? 'selected' : '' }}>Albañil
                    </option>
                    <option value="chofer" {{ ($filters['sector_otros'] ?? '') === 'chofer' ? 'selected' : '' }}>Chofer
                    </option>
                    <option value="administracion"
                        {{ ($filters['sector_otros'] ?? '') === 'administracion' ? 'selected' : '' }}>Administración
                    </option>
                </select>
            </div>

            <div class="col-span-1 flex items-end">
                <button type="submit" class="btn btn-primary w-full md:w-auto">Buscar</button>
            </div>
        </form>

        <p class="text-text-secondary mb-4">
            Mostrando <span class="font-semibold text-primary">{{ $graduates->total() }}</span> resultados
        </p>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-border-primary">
                <thead class="bg-gray-lighter">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">Nombre
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">Cohorte
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">Género
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">Empresa
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">Puesto
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">Sector
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
                                @php
                                    $sector = $grad->sector;
                                    $badgeClass = 'badge';
                                    if (
                                        in_array($sector, [
                                            'desarrollo_software',
                                            'infraestructura',
                                            'analisis_datos',
                                            'seguridad_informatica',
                                        ])
                                    ) {
                                        $badgeClass .= ' badge-success';
                                    } elseif (in_array($sector, ['vendedor', 'albanil', 'chofer', 'administracion'])) {
                                        $badgeClass .= ' badge-warning';
                                    }
                                @endphp
                                <span class="{{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $sector)) }}</span>
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
            {{ $graduates->withQueryString()->links('pagination::tailwind') }}
        </div>
    </div>

    <script>
        function toggleSectorSelectors() {
            const areaLaboral = document.getElementById('area_laboral').value;
            const tecnologiaDiv = document.getElementById('sector_tecnologia_div');
            const otrosDiv = document.getElementById('sector_otros_div');

            if (areaLaboral === 'tecnologia') {
                tecnologiaDiv.style.display = 'block';
                otrosDiv.style.display = 'none';
            } else if (areaLaboral === 'otros') {
                tecnologiaDiv.style.display = 'none';
                otrosDiv.style.display = 'block';
            } else {
                tecnologiaDiv.style.display = 'none';
                otrosDiv.style.display = 'none';
            }
        }

        document.getElementById('area_laboral').addEventListener('change', toggleSectorSelectors);

        // Ejecutar al cargar la página para mantener estado
        window.onload = toggleSectorSelectors;
    </script>
@endsection
