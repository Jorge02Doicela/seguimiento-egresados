@props([
    'title' => null,
    'headers' => [],
    'rows' => [],
])

<div class="card shadow-sm rounded-lg overflow-hidden mb-6 animate-fade-in">
    @if ($title)
        <div class="card-header bg-primary text-white font-semibold text-lg py-2 px-4">
            {{ $title }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm m-0">
            <thead class="table-light">
                <tr>
                    @foreach ($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $row)
                    <tr>
                        @foreach ($row as $cell)
                            <td>{{ $cell }}</td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($headers) }}" class="text-center">No hay datos</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
