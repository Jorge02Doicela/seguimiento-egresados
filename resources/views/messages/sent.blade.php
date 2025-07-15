@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-text-primary mb-6">Mensajes Enviados</h2>

        @if ($messages->count() === 0)
            <div class="bg-info-lighter text-info-dark px-4 py-3 rounded-lg mb-6 shadow-sm" role="alert">
                No has enviado mensajes aún.
            </div>
        @else
            <div class="bg-white shadow-md rounded-2xl overflow-hidden mb-8">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="bg-gray-light border-b border-gray-lighter">
                            <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                                Para</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                                Mensaje</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">
                                Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                            <tr
                                class="border-b border-gray-lighter hover:bg-bg-secondary transition-colors duration-200 text-text-secondary">
                                <td class="px-5 py-4 text-sm">{{ $message->receiver->name }}</td>
                                <td class="px-5 py-4 text-sm">
                                    <a href="{{ route('messages.show', $message->id) }}"
                                        class="text-primary hover:text-primary-dark underline font-medium">
                                        {{ Str::limit($message->content, 50) }}
                                    </a>
                                </td>
                                <td class="px-5 py-4 text-sm">{{ $message->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-center">
                {{ $messages->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
@endsection
