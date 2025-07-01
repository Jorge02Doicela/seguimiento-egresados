@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Bandeja de Entrada</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse($messages as $message)
        <div class="card mb-3 {{ $message->read ? '' : 'border-primary' }}">
            <div class="card-header">
                De: {{ $message->sender->name }} — {{ $message->created_at->diffForHumans() }}
                @if(!$message->read)
                    <form action="{{ route('messages.read', $message->id) }}" method="POST" class="d-inline float-end">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Marcar como leído</button>
                    </form>
                @endif
            </div>
            <div class="card-body">
                <p>{{ $message->content }}</p>
            </div>
        </div>
    @empty
        <p>No tienes mensajes.</p>
    @endforelse

    {{ $messages->links() }}
</div>
@endsection
