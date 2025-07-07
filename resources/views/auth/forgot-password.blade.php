<x-guest-layout>
    {{-- Contenedor principal con imagen de fondo del ISUS y estilo institucional --}}
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50 p-4 sm:p-0"
        style="background-image: url('https://tecnologicosucre.edu.ec/web/assets/images/bg-login.jpg'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat;">

        {{-- Logo y Sección de Título Institucional (adaptado para Recuperar Contraseña) --}}
        <div class="w-full sm:max-w-md flex flex-col items-center mb-6">

            {{-- Título del sistema o de la acción --}}
            <h1 class="text-center text-white bg-blue-institutional px-5 py-3 rounded-xl shadow-primary mt-4 font-montserrat tracking-wide leading-tight">
                <span class="block text-2xl sm:text-3xl font-extrabold mb-1">Recuperar Contraseña</span>
                <span class="block text-xs sm:text-sm font-normal opacity-80 mt-1">Recibe un enlace para restablecer tu contraseña</span>
            </h1>
        </div>

        {{-- Tarjeta del Formulario de Recuperación --}}
        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-2xl rounded-xl overflow-hidden backdrop-blur-sm bg-opacity-85 border border-primary-lightest transform transition-all duration-300 hover:scale-[1.01] hover:shadow-3xl">

            {{-- Mensaje introductorio --}}
            <div class="mb-6 text-base text-text-secondary font-open-sans">
                {{ __('¿Olvidaste tu contraseña? Ingresa tu correo electrónico y te enviaremos un enlace para que puedas crear una nueva contraseña.') }}
            </div>

            {{-- Estado de la Sesión --}}
            <x-auth-session-status class="mb-6 px-4 py-3 bg-primary-lightest text-primary-dark rounded-lg border border-primary-light text-base font-open-sans" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-6">
                    <x-input-label for="email" :value="__('Correo electrónico')" class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <x-text-input id="email" class="block w-full pl-3 pr-3 py-2 border border-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary placeholder-gray-400 font-open-sans"
                            type="email" name="email" :value="old('email')" required autofocus placeholder="usuario@tecnologicosucre.edu.ec" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-error font-open-sans" />
                </div>

                <div class="flex items-center justify-center mt-6">
                    <x-primary-button
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-primary text-base font-semibold text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-200 ease-in-out transform hover:scale-[1.01] font-montserrat">
                        {{ __('Enviar Enlace de Restablecimiento de Contraseña') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        {{-- Footer Institucional --}}
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 text-center bg-white/90 rounded-lg shadow-lg border border-primary-lightest">
            <p class="text-sm text-text-secondary font-open-sans">
                © {{ date('Y') }} Instituto Superior Universitario Tecnológico Sucre
            </p>
        </div>
    </div>
</x-guest-layout>
