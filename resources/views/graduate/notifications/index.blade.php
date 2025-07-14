@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Notificaciones</h2>

        @foreach ($notifications as $notification)
            <div class="mb-4 p-4 border rounded-lg {{ $notification->read_at ? 'bg-gray-100' : 'bg-white' }}">
                <p class="mb-2">{{ $notification->data['title'] ?? 'Nueva notificación' }}</p>
                <p class="text-sm text-gray-600">{{ $notification->created_at->diffForHumans() }}</p>

                @if (!$notification->read_at)
                    <form method="POST"action="{{ route('graduate.notifications.markAsRead', $notification->id) }}"
                        class="mt-2">
                        @csrf
                        <button type="submit" class="text-blue-600 hover:underline text-sm">Marcar como leída</button>
                    </form>
                @endif
            </div>
        @endforeach

        {{ $notifications->links() }}
    </div>
@endsection
