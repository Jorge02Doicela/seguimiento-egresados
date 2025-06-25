@extends('layouts.app')

@section('title', 'Encuestas disponibles')

@section('content')
<h2>Encuestas disponibles</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($surveys->count())
    <ul class="list-group">
        @foreach($surveys as $survey)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $survey->title }}
                <a href="{{ route('graduate.surveys.show', $survey) }}" class="btn btn-primary btn-sm">Responder</a>
            </li>
        @endforeach
    </ul>

    <div class="mt-3">
        {{ $surveys->links() }}
    </div>
@else
    <p>No hay encuestas disponibles en este momento.</p>
@endif

@endsection
