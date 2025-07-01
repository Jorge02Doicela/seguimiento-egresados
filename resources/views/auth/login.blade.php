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
            <h1 class="text-center text-white bg-blue-institutional px-5 py-3 rounded-xl shadow-xl mt-4 font-montserrat tracking-wide leading-tight">
                {{-- Título principal (un poco más pequeño para dejar espacio) --}}
                {{--SIVEP-Sucre Sistema de Información y Vinculación con Egresados Profesionales npm run dev--}}
                <span class="block text-2xl sm:text-3xl font-extrabold mb-1">Sistema Académico SIVEP</span>
                {{-- Descripción y tagline (con menor tamaño y peso) --}}
                <span class="block text-xs sm:text-sm font-normal opacity-80 mt-1">Conectando la formación académica con el futuro profesional</span>
            </h1>
        </div>

        {{-- Tarjeta de Login Re-estilizada --}}
        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-2xl rounded-xl overflow-hidden backdrop-blur-sm bg-opacity-85 border border-blue-100 transform transition-all duration-300 hover:scale-[1.01] hover:shadow-3xl">
            {{-- Mensaje de estado de la sesión --}}
            <x-auth-session-status class="mb-6 px-4 py-3 bg-blue-50 text-blue-800 rounded-lg border border-blue-200 text-base font-open-sans" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Campo de Correo Institucional --}}
                <div class="mb-6">
                    <x-input-label for="email" :value="__('Correo Electrónico')" class="block text-sm font-semibold text-gray-700 mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            {{-- Icono de correo mejorado --}}
                            <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <x-text-input id="email" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 placeholder-gray-400 font-open-sans"
                            type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="usuario@tecnologicosucre.edu.ec" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 font-open-sans" />
                </div>

                {{-- Campo de Contraseña --}}
                <div class="mb-6">
                    <x-input-label for="password" :value="__('Contraseña')" class="block text-sm font-semibold text-gray-700 mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            {{-- Icono de candado mejorado --}}
                            <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <x-text-input id="password" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 placeholder-gray-400 font-open-sans"
                            type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 font-open-sans" />
                </div>

                {{-- Recordar Sesión y Olvidó Contraseña --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded-md cursor-pointer">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700 font-open-sans cursor-pointer">Recordar sesión</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-blue-600 hover:text-blue-800 font-medium hover:underline font-open-sans transition duration-150 ease-in-out">
                            ¿Olvidó su contraseña?
                        </a>
                    @endif
                </div>

                {{-- Botón de Iniciar Sesión --}}
                <div class="flex items-center justify-center">
                    <button type="submit"
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-md text-base font-semibold text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition duration-200 ease-in-out transform hover:scale-[1.01] font-montserrat">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Iniciar Sesión
                    </button>
                </div>
            </form>
        </div>

        {{-- Footer Institucional --}}
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 text-center bg-white/90 rounded-lg shadow-lg border border-blue-100">
            <p class="text-sm text-gray-700 font-open-sans">
                © {{ date('Y') }} Instituto Superior Universitario Tecnológico Sucre
            </p>
        </div>
    </div>
</x-guest-layout>
