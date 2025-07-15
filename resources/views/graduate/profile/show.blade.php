@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 md:p-8">
        <h1 class="text-4xl font-headings text-text-primary mb-6">Perfil de Egresado</h1>

        @if (session('success'))
            <div class="bg-success-lighter text-success-dark px-4 py-3 rounded-lg mb-4 text-sm" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-2xl p-6 mb-8">
            <h3 class="text-2xl font-headings text-text-primary mb-4 border-b border-border-primary pb-2">Información General
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3 text-lg">
                <p><strong>Año de cohorte de egreso:</strong> <span
                        class="text-text-secondary">{{ $graduate->cohort_year }}</span></p>
                <p><strong>Género:</strong> <span class="text-text-secondary">{{ $graduate->gender }}</span></p>
                <p><strong>Carrera:</strong>
                    <span class="text-text-secondary">
                        {{ $graduate->career->name ?? 'No asignada' }}
                    </span>
                </p>

                <p><strong>¿Está trabajando actualmente?</strong>
                    <span class="font-semibold {{ $graduate->is_working ? 'text-success' : 'text-error' }}">
                        {{ $graduate->is_working ? 'Sí' : 'No' }}
                    </span>
                </p>
            </div>

            @if ($graduate->is_working)
                <h3 class="text-2xl font-headings text-text-primary mt-6 mb-4 border-b border-border-primary pb-2">Detalles
                    Laborales</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3 text-lg">
                    <p><strong>Empresa:</strong> <span
                            class="text-text-secondary">{{ $graduate->company ?? 'No registrado' }}</span></p>
                    <p><strong>Cargo:</strong> <span
                            class="text-text-secondary">{{ $graduate->position ?? 'No registrado' }}</span></p>
                    <p><strong>Salario $:</strong> <span
                            class="text-text-secondary">{{ $graduate->salary ?? 'No registrado' }}</span></p>

                </div>
            @endif

            <h3 class="text-2xl font-headings text-text-primary mt-6 mb-4 border-b border-border-primary pb-2">Contacto y
                Documentos</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3 text-lg">
                <p><strong>Portafolio:</strong>
                    @if ($graduate->portfolio_url)
                        <a href="{{ $graduate->portfolio_url }}" target="_blank"
                            class="text-primary hover:text-primary-dark transition-colors duration-300">Ver portafolio</a>
                    @else
                        <span class="text-text-muted">No registrado</span>
                    @endif
                </p>
                <p><strong>CV:</strong>
                    @if ($graduate->cv_path)
                        <a href="{{ asset('storage/' . $graduate->cv_path) }}" target="_blank"
                            class="text-primary hover:text-primary-dark transition-colors duration-300">Ver CV</a>
                    @else
                        <span class="text-text-muted">No registrado</span>
                    @endif
                </p>
                <p><strong>País:</strong> <span
                        class="text-text-secondary">{{ $graduate->country ?? 'No registrado' }}</span></p>
                <p><strong>Ciudad:</strong> <span
                        class="text-text-secondary">{{ $graduate->city ?? 'No registrado' }}</span></p>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-2xl p-6 mb-8">
            <h3 class="text-2xl font-headings text-text-primary mb-4 border-b border-border-primary pb-2">Habilidades</h3>
            <ul class="list-disc list-inside text-lg text-text-secondary">
                @forelse($graduate->skills as $skill)
                    <li class="mb-1">{{ $skill->name }}</li>
                @empty
                    <li class="text-text-muted">No se han registrado habilidades.</li>
                @endforelse
            </ul>
        </div>

        <div class="flex justify-start">
            <a href="{{ route('graduate.profile.edit') }}" class="btn btn-primary">Editar Perfil</a>
        </div>
    </div>
@endsection
