@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-text-primary mb-6">Encuestas disponibles</h1>

        @if (session('success'))
            <div class="bg-success-lighter text-success-dark px-4 py-3 rounded-lg mb-6 shadow-sm" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-error-lighter text-error px-4 py-3 rounded-lg mb-6 shadow-sm" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if ($surveys->isEmpty())
            <div class="bg-info-lighter text-info-dark px-4 py-3 rounded-lg mb-6 shadow-sm" role="alert">
                No hay encuestas activas para tu carrera en este momento.
            </div>
        @else
            <ul class="grid gap-6">
                @foreach ($surveys as $survey)
                    <li class="bg-white p-6 rounded-2xl shadow-primary-md border border-gray-lighter">
                        <h3 class="text-xl font-semibold text-text-primary mb-2">{{ $survey->title }}</h3>
                        <p class="text-text-secondary mb-4 leading-relaxed">{{ $survey->description }}</p>
                        <a href="{{ route('graduate.surveys.show', $survey) }}"
                            class="btn btn-primary px-5 py-2 shadow-primary hover:shadow-primary-dark">Responder</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
