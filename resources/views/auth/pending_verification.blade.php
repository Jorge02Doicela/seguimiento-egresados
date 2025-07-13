<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cuenta pendiente de verificación</title>
    @vite(['resources/css/app.css']) {{-- Incluye Tailwind --}}
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-lg p-10 max-w-lg text-center">

        <svg class="mx-auto mb-6 w-16 h-16 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v2m0 4h.01M4.93 19.07a10 10 0 1114.14 0 10 10 0 01-14.14 0z" />
        </svg>

        <h1 class="text-2xl font-bold text-gray-800 mb-4">Cuenta pendiente de verificación</h1>

        <p class="text-gray-600 mb-6">
            Tu cuenta está pendiente de verificación por parte del administrador.<br />
            Por favor, espera a que sea revisada y activada para poder acceder.
        </p>

        <div class="flex justify-center gap-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-6 py-2 rounded bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                    Cerrar sesión
                </button>
            </form>
            <a href="{{ url('/') }}"
                class="px-6 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                Volver al inicio
            </a>
        </div>
    </div>

</body>

</html>
