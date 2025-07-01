@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Notificaciones</h2>

    @forelse($notifications as $notification)
        <div class="alert alert-{{ $notification->read_at ? 'secondary' : 'info' }}">
            <strong>{{ $notification->data['title'] ?? 'Sin título' }}</strong> — {{ $notification->data['message'] ?? '' }}
            <br>
            <small>{{ $notification->created_at->diffForHumans() }}</small>

            @if(!$notification->read_at)
                <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-inline float-end">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success">Marcar como leído</button>
                </form>
            @endif
        </div>
    @empty
        <p>No tienes notificaciones.</p>
    @endforelse

    {{ $notifications->links() }}
</div>
@endsection
