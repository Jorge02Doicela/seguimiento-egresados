@extends('layouts.app')

@section('title', 'Notificaciones')

@section('content')
    <div class="container mt-4">
        <h2>Notificaciones</h2>

        @if ($notifications->count())
            @foreach ($notifications as $notification)
                <div class="alert alert-{{ $notification->read_at ? 'secondary' : 'info' }}">
                    <strong>{{ $notification->data['title'] ?? 'Sin título' }}</strong> —
                    {{ $notification->data['message'] ?? '' }}
                    <br>
                    <small>{{ $notification->created_at->diffForHumans() }}</small>

                    @if (!$notification->read_at)
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST"
                            class="d-inline float-end">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Marcar como leído</button>
                        </form>
                    @endif
                </div>
            @endforeach

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="alert alert-warning">
                <i class="bi bi-bell-slash"></i> No tienes notificaciones.
            </div>
        @endif
    </div>
@endsection
