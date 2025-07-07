<x-guest-layout>
    {{-- Contenedor principal con imagen de fondo del ISUS y estilo institucional --}}
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50 p-4 sm:p-0"
        style="background-image: url('https://tecnologicosucre.edu.ec/web/assets/images/bg-login.jpg'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat;">

        {{-- Logo y Sección de Título Institucional --}}
        <div class="w-full sm:max-w-md flex flex-col items-center mb-6">
            {{-- Logo oficial del ISUS --}}
            <img src="https://tecnologicosucre.edu.ec/web/wp-content/uploads/2023/08/OP1-mod.png"
                alt="Logo Instituto Tecnológico Sucre" class="h-24 sm:h-28 mb-6 drop-shadow-lg">

            {{-- Título del sistema ampliado con descripción y tagline --}}
            <h1 class="text-center text-white bg-blue-institutional px-5 py-3 rounded-xl shadow-primary mt-4 font-montserrat tracking-wide leading-tight">
                <span class="block text-2xl sm:text-3xl font-extrabold mb-1">Verificación de Email - SEI</span>
                <span class="block text-xs sm:text-sm font-normal opacity-80 mt-1">Confirma tu dirección de correo electrónico</span>
            </h1>
        </div>

        {{-- Tarjeta de Verificación Re-estilizada --}}
        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-2xl rounded-xl overflow-hidden backdrop-blur-sm bg-opacity-85 border border-primary-lightest transform transition-all duration-300 hover:scale-[1.01] hover:shadow-3xl">

            {{-- Mensaje introductorio --}}
            <div class="mb-6 text-base text-text-secondary font-open-sans">
                {{ __('¡Gracias por registrarte! Antes de empezar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que acabamos de enviarte? Si no recibiste el correo, con gusto te enviaremos otro.') }}
            </div>

            {{-- Mensaje de éxito al reenviar el enlace --}}
            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 px-4 py-3 bg-success-light text-success-dark rounded-lg border border-success text-base font-open-sans">
                    {{ __('Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionaste durante el registro.') }}
                </div>
            @endif

            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 sm:space-x-4">
                {{-- Formulario para reenviar el email de verificación --}}
                <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                    @csrf
                    <div>
                        <x-primary-button
                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-primary text-base font-semibold text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-200 ease-in-out transform hover:scale-[1.01] font-montserrat">
                            {{ __('Reenviar Email de Verificación') }}
                        </x-primary-button>
                    </div>
                </form>

                {{-- Formulario para cerrar sesión --}}
                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit"
                        class="w-full text-center underline text-sm text-text-muted hover:text-error rounded-md
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-error transition duration-150 ease-in-out font-open-sans">
                        {{ __('Cerrar Sesión') }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Footer Institucional --}}
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 text-center bg-white/90 rounded-lg shadow-lg border border-primary-lightest">
            <p class="text-sm text-text-secondary font-open-sans">
                © {{ date('Y') }} Instituto Superior Universitario Tecnológico Sucre
            </p>
        </div>
    </div>
</x-guest-layout>
