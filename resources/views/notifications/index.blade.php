@extends('layouts.app')

@section('title', 'Notificaciones')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <h2 class="text-3xl font-headings text-text-primary mb-6">Notificaciones</h2>

        @if ($notifications->count())
            <div class="space-y-4">
                @foreach ($notifications as $notification)
                    <div
                        class="
                        p-5 rounded-lg shadow-sm flex items-start space-x-4
                        @if ($notification->read_at) bg-gray-lighter text-text-secondary border border-border-secondary
                        @else
                            bg-primary-lightest text-text-primary border border-primary-light @endif
                    ">
                        <div class="flex-grow">
                            <strong
                                class="font-semibold text-text-secondary text-lg">{{ $notification->data['title'] ?? 'Sin título' }}</strong>
                            <p class="text-text-secondary mt-1">{{ $notification->data['message'] ?? '' }}</p>
                            <small class="text-text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>

                        @if (!$notification->read_at)
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST"
                                class="flex-shrink-0">
                                @csrf
                                <button type="submit" class="btn btn-success">Marcar como leído</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="bg-warning-lighter text-warning-dark p-4 rounded-lg flex items-center space-x-3 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.043 5.455 1.31m5.714 0a24.246 24.246 0 00-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                <span>No tienes notificaciones.</span>
            </div>
        @endif
    </div>
@endsection
