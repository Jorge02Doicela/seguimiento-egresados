@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-8">
        <h2 class="text-2xl font-semibold mb-6">Mensajes Enviados</h2>

        @if ($messages->count() === 0)
            <p>No has enviado mensajes aún.</p>
        @else
            <table class="w-full border-collapse border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Para</th>
                        <th class="border px-4 py-2">Mensaje</th>
                        <th class="border px-4 py-2">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $message)
                        <tr>
                            <td class="border px-4 py-2">{{ $message->receiver->name }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('messages.show', $message->id) }}" class="text-blue-600 hover:underline">
                                    {{ Str::limit($message->content, 50) }}
                                </a>
                            </td>
                            <td class="border px-4 py-2">{{ $message->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
@endsection
