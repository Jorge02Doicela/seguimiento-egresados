@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Perfil de Egresado</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <p><strong>Año de cohorte de egreso:</strong> {{ $graduate->cohort_year }}</p>
        <p><strong>Género:</strong> {{ $graduate->gender }}</p>

        <p><strong>¿Está trabajando actualmente?</strong>
            {{ $graduate->is_working ? 'Sí' : 'No' }}
        </p>

        @if ($graduate->is_working)
            <p><strong>Empresa:</strong> {{ $graduate->company ?? 'No registrado' }}</p>
            <p><strong>Cargo:</strong> {{ $graduate->position ?? 'No registrado' }}</p>
            <p><strong>Salario:</strong> {{ $graduate->salary ?? 'No registrado' }}</p>
            <p><strong>Sector:</strong> {{ $graduate->sector ?? 'No registrado' }}</p>
        @endif

        <p><strong>Portafolio:</strong>
            @if ($graduate->portfolio_url)
                <a href="{{ $graduate->portfolio_url }}" target="_blank">Ver portafolio</a>
            @else
                No registrado
            @endif
        </p>

        <p><strong>CV:</strong>
            @if ($graduate->cv_path)
                <a href="{{ asset('storage/' . $graduate->cv_path) }}" target="_blank">Ver CV</a>
            @else
                No registrado
            @endif
        </p>

        <p><strong>País:</strong> {{ $graduate->country ?? 'No registrado' }}</p>
        <p><strong>Ciudad:</strong> {{ $graduate->city ?? 'No registrado' }}</p>

        <h3>Habilidades</h3>
        <ul>
            @forelse($graduate->skills as $skill)
                <li>{{ $skill->name }}</li>
            @empty
                <li>No se han registrado habilidades.</li>
            @endforelse
        </ul>

        <a href="{{ route('graduate.profile.edit') }}" class="btn btn-primary">Editar Perfil</a>
    </div>
@endsection
