@extends('layouts.app')

@section('title', 'Ver Mensaje')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Mensaje de {{ $message->sender->name ?? 'Desconocido' }}</h1>

        <div class="card">
            <div class="card-header">
                Recibido el {{ $message->created_at->format('d/m/Y H:i') }}
            </div>
            <div class="card-body">
                <p style="white-space: pre-wrap;">{{ $message->content }}</p>

                @if ($message->attachment_path)
                    <p class="mt-3">
                        Archivo adjunto:
                        <a href="{{ route('messages.attachment', $message->id) }}" target="_blank"
                            class="underline text-blue-600">
                            Descargar / Ver archivo
                        </a>
                    </p>
                @endif
            </div>
        </div>

        <a href="{{ route('messages.inbox') }}" class="btn btn-primary mt-3">
            <i class="bi bi-arrow-left"></i> Volver a la bandeja
        </a>
    </div>
@endsection
