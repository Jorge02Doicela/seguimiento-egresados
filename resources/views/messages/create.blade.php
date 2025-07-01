@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Enviar Mensaje</h2>

    <form action="{{ route('messages.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="receiver_id" class="form-label">Para</label>
            <select name="receiver_id" id="receiver_id" class="form-select" required>
                <option value="">Selecciona un usuario</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('receiver_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            @error('receiver_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Mensaje</label>
            <textarea name="content" id="content" rows="4" class="form-control" required>{{ old('content') }}</textarea>
            @error('content')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button class="btn btn-primary" type="submit">Enviar</button>
    </form>
</div>
@endsection
