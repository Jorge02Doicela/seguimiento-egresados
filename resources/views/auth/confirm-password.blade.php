<x-guest-layout>
    {{-- Contenedor principal con imagen de fondo del ISUS y estilo institucional --}}
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50 p-4 sm:p-0"
        style="background-image: url('https://tecnologicosucre.edu.ec/web/assets/images/bg-login.jpg'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat;">

        {{-- Logo y Sección de Título Institucional (adaptado para Confirmar Contraseña) --}}
        <div class="w-full sm:max-w-md flex flex-col items-center mb-6">
            {{-- Logo oficial del ISUS --}}
            <img src="https://tecnologicosucre.edu.ec/web/wp-content/uploads/2023/08/OP1-mod.png"
                alt="Logo Instituto Tecnológico Sucre" class="h-24 sm:h-28 mb-6 drop-shadow-lg">

            {{-- Título del sistema o de la acción --}}
            <h1
                class="text-center text-white bg-blue-institutional px-5 py-3 rounded-xl shadow-primary mt-4 font-montserrat tracking-wide leading-tight">
                <span class="block text-2xl sm:text-3xl font-extrabold mb-1">Confirmar Contraseña</span>
                <span class="block text-xs sm:text-sm font-normal opacity-80 mt-1">Acceso seguro a tu cuenta</span>
            </h1>
        </div>

        {{-- Tarjeta del Formulario de Confirmación --}}
        <div
            class="w-full sm:max-w-md px-6 py-8 bg-white shadow-2xl rounded-xl overflow-hidden backdrop-blur-sm bg-opacity-85 border border-primary-lightest transform transition-all duration-300 hover:scale-[1.01] hover:shadow-3xl">

            {{-- Mensaje introductorio --}}
            <div class="mb-6 text-base text-text-secondary font-open-sans">
                {{ __('Esta es un área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-6 relative">
                    <x-input-label for="password" :value="__('Contraseña')"
                        class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <x-text-input id="password"
                            class="block w-full pl-3 pr-12 py-2 border border-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary placeholder-gray-400 font-open-sans"
                            type="password" name="password" required autocomplete="current-password"
                            placeholder="••••••••" />

                        <button type="button" id="btn-show-password" onmousedown="showPassword('password')"
                            onmouseup="hidePassword('password')" onmouseleave="hidePassword('password')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-600 hover:text-blue-800 focus:outline-none"
                            aria-label="Mostrar contraseña" title="Mantén presionado para ver contraseña">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="#0000FF" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-error font-open-sans" />
                </div>

                <div class="flex items-center justify-center mt-6">
                    <x-primary-button
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-primary text-base font-semibold text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-200 ease-in-out transform hover:scale-[1.01] font-montserrat">
                        {{ __('Confirmar') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        {{-- Footer Institucional --}}
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 text-center bg-white/90 rounded-lg shadow-lg border border-primary-lightest">
            <p class="text-sm text-text-secondary font-open-sans">
                © {{ date('Y') }} Instituto Superior Universitario Tecnológico Sucre
            </p>
        </div>
    </div>

    <script>
        // Mostrar y ocultar contraseña con mantener presionado el botón
        function showPassword(id) {
            const input = document.getElementById(id);
            if (input) {
                input.type = 'text';
            }
        }

        function hidePassword(id) {
            const input = document.getElementById(id);
            if (input) {
                input.type = 'password';
            }
        }
    </script>
</x-guest-layout>
