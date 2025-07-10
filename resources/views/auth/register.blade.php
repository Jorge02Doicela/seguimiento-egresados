<x-guest-layout>
    {{-- Contenedor principal con imagen de fondo del ISUS y estilo institucional --}}
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50 p-4 sm:p-0"
        style="background-image: url('https://tecnologicosucre.edu.ec/web/assets/images/bg-login.jpg'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat;">

        {{-- Logo y Sección de Título Institucional --}}
        <div class="w-full sm:max-w-md flex flex-col items-center mb-6">

            {{-- Título del sistema ampliado con descripción y tagline --}}
            <h1
                class="text-center text-white bg-blue-institutional px-5 py-3 rounded-xl shadow-primary mt-4 font-montserrat tracking-wide leading-tight">
                <span class="block text-2xl sm:text-3xl font-extrabold mb-1">Registro de Usuarios - SEI</span>
                <span class="block text-xs sm:text-sm font-normal opacity-80 mt-1">Únete a nuestra comunidad de egresados
                    y empleadores</span>
            </h1>
        </div>

        {{-- Tarjeta de Registro Re-estilizada --}}
        <div
            class="w-full sm:max-w-md px-6 py-8 bg-white shadow-2xl rounded-xl overflow-hidden backdrop-blur-sm bg-opacity-85 border border-primary-lightest transform transition-all duration-300 hover:scale-[1.01] hover:shadow-3xl">
            {{-- Mensajes de error de validación --}}
            @if ($errors->any())
                <div
                    class="mb-6 px-4 py-3 bg-red-50 text-red-800 rounded-lg border border-red-200 text-base font-open-sans">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Campo de Nombre --}}
                <div class="mb-6">
                    <x-input-label for="name" :value="__('Nombre completo')"
                        class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <x-text-input id="name"
                            class="block w-full pl-10 pr-3 py-2 border border-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary placeholder-gray-400 font-open-sans"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                            placeholder="Tu nombre completo" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600 font-open-sans" />
                </div>

                {{-- Campo de Correo electrónico --}}
                <div class="mb-6">
                    <x-input-label for="email" :value="__('Correo electrónico')"
                        class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <x-text-input id="email"
                            class="block w-full pl-10 pr-3 py-2 border border-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary placeholder-gray-400 font-open-sans"
                            type="email" name="email" :value="old('email')" required autocomplete="username"
                            placeholder="usuario@tecnologicosucre.edu.ec" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-error font-open-sans" />
                </div>

                {{-- Campo de Contraseña --}}
                <div class="mb-6 relative">
                    <x-input-label for="password" :value="__('Contraseña')"
                        class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <x-text-input id="password"
                            class="block w-full pl-10 pr-12 py-2 border border-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary placeholder-gray-400 font-open-sans"
                            type="password" name="password" required autocomplete="new-password"
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

                {{-- Campo de Confirmar contraseña --}}
                <div class="mb-6 relative">
                    <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')"
                        class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <x-text-input id="password_confirmation"
                            class="block w-full pl-10 pr-12 py-2 border border-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary placeholder-gray-400 font-open-sans"
                            type="password" name="password_confirmation" required autocomplete="new-password"
                            placeholder="••••••••" />

                        <button type="button" id="btn-show-password-confirm"
                            onmousedown="showPassword('password_confirmation')"
                            onmouseup="hidePassword('password_confirmation')"
                            onmouseleave="hidePassword('password_confirmation')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-600 hover:text-blue-800 focus:outline-none"
                            aria-label="Mostrar confirmar contraseña" title="Mantén presionado para ver contraseña">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="#0000FF" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-error font-open-sans" />
                </div>

                {{-- Campo de Rol del usuario --}}
                <div class="mb-6">
                    <x-input-label for="role" :value="__('Selecciona tu rol')"
                        class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <select id="role" name="role" required
                            class="block w-full pl-10 pr-3 py-2 border border-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary font-open-sans">
                            <option value="">-- Selecciona --</option>
                            <option value="graduate" {{ old('role') == 'graduate' ? 'selected' : '' }}>Egresado
                            </option>
                            <option value="employer" {{ old('role') == 'employer' ? 'selected' : '' }}>Empleador
                            </option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('role')" class="mt-2 text-sm text-error font-open-sans" />
                </div>

                {{-- Campos adicionales para Empleador --}}
                <div id="employerFields" style="display: none;">
                    {{-- ... campos para empleador ... --}}
                    <!-- (Los campos que ya tienes para empleador aquí, los omití para brevedad) -->
                </div>

                {{-- Botón de registro y enlace de login --}}
                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-blue-900 hover:text-primary rounded-md
   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-150 ease-in-out font-open-sans"
                        href="{{ route('login') }}">
                        {{ __('¿Ya tienes una cuenta?') }}
                    </a>

                    <button type="submit"
                        class="ml-4 flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-primary text-base font-semibold text-white bg-blue-institutional hover:bg-blue-institutional-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-institutional transition duration-200 ease-in-out transform hover:scale-[1.01] font-montserrat">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ __('Registrarse') }}
                    </button>
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
</x-guest-layout>

<script>
    // Mostrar/ocultar campos para empleador
    function toggleEmployerFields() {
        const roleSelect = document.getElementById('role');
        const employerFields = document.getElementById('employerFields');
        const employerInputs = employerFields.querySelectorAll('input, select');

        if (roleSelect.value === 'employer') {
            employerFields.style.display = 'block';
            employerInputs.forEach(input => input.setAttribute('required', 'true'));
        } else {
            employerFields.style.display = 'none';
            employerInputs.forEach(input => input.removeAttribute('required'));
        }
    }

    document.getElementById('role').addEventListener('change', toggleEmployerFields);

    // Ejecutar al cargar la página para mantener el estado si hay errores de validación
    window.onload = function() {
        toggleEmployerFields();
    };

    // Funciones para mostrar y ocultar contraseña mientras se presiona el botón
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
