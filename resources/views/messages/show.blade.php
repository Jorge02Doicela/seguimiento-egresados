@extends('layouts.app')

@section('title', 'Ver Mensaje')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-text-primary mb-6">Mensaje de {{ $message->sender->name ?? 'Desconocido' }}</h1>

        <div class="bg-white rounded-2xl shadow-primary-lg overflow-hidden max-w-2xl mx-auto">
            <div class="bg-gray-light px-6 py-4 border-b border-gray-lighter text-text-muted text-sm font-semibold">
                Recibido el {{ $message->created_at->format('d/m/Y H:i') }}
            </div>
            <div class="p-6">
                <p class="text-text-secondary leading-relaxed" style="white-space: pre-wrap;">{{ $message->content }}</p>

                @if ($message->attachment_path)
                    <p class="mt-4 text-text-secondary">
                        Archivo adjunto:
                        <a href="{{ route('messages.attachment', $message->id) }}" target="_blank"
                            class="text-primary hover:text-primary-dark underline font-medium">
                            Descargar / Ver archivo
                        </a>
                    </p>
                @endif
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('messages.inbox') }}"
                class="btn btn-primary px-6 py-3 shadow-primary hover:shadow-primary-dark inline-flex items-center">
                <i class="bi bi-arrow-left mr-2"></i> Volver a la bandeja
            </a>
        </div>
    </div>
@endsection
