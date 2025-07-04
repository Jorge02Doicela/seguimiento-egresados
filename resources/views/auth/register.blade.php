<x-guest-layout>
    {{-- Contenedor principal con imagen de fondo del ISUS y estilo institucional --}}
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50 p-4 sm:p-0"
        style="background-image: url('https://tecnologicosucre.edu.ec/web/assets/images/bg-login.jpg'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat;">

        {{-- Logo y Sección de Título Institucional --}}
        <div class="w-full sm:max-w-md flex flex-col items-center mb-6">

            {{-- Título del sistema ampliado con descripción y tagline --}}
            <h1 class="text-center text-white bg-blue-institutional px-5 py-3 rounded-xl shadow-xl mt-4 font-montserrat tracking-wide leading-tight">
                <span class="block text-2xl sm:text-3xl font-extrabold mb-1">Registro de Usuarios - SEI</span>
                <span class="block text-xs sm:text-sm font-normal opacity-80 mt-1">Únete a nuestra comunidad de egresados y empleadores</span>
            </h1>
        </div>

        {{-- Tarjeta de Registro Re-estilizada --}}
        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-2xl rounded-xl overflow-hidden backdrop-blur-sm bg-opacity-85 border border-blue-100 transform transition-all duration-300 hover:scale-[1.01] hover:shadow-3xl">
            {{-- Mensajes de error de validación --}}
            @if ($errors->any())
                <div class="mb-6 px-4 py-3 bg-red-50 text-red-800 rounded-lg border border-red-200 text-base font-open-sans">
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
                    <x-input-label for="name" :value="__('Nombre completo')" class="block text-sm font-semibold text-gray-700 mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <x-text-input id="name" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 placeholder-gray-400 font-open-sans"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Tu nombre completo" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600 font-open-sans" />
                </div>

                {{-- Campo de Correo electrónico --}}
                <div class="mb-6">
                    <x-input-label for="email" :value="__('Correo electrónico')" class="block text-sm font-semibold text-gray-700 mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <x-text-input id="email" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 placeholder-gray-400 font-open-sans"
                            type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="usuario@tecnologicosucre.edu.ec" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 font-open-sans" />
                </div>

                {{-- Campo de Contraseña --}}
                <div class="mb-6">
                    <x-input-label for="password" :value="__('Contraseña')" class="block text-sm font-semibold text-gray-700 mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <x-text-input id="password" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 placeholder-gray-400 font-open-sans"
                            type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 font-open-sans" />
                </div>

                {{-- Campo de Confirmar contraseña --}}
                <div class="mb-6">
                    <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" class="block text-sm font-semibold text-gray-700 mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <x-text-input id="password_confirmation" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 placeholder-gray-400 font-open-sans"
                            type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600 font-open-sans" />
                </div>

                {{-- Campo de Rol del usuario --}}
                <div class="mb-6">
                    <x-input-label for="role" :value="__('Selecciona tu rol')" class="block text-sm font-semibold text-gray-700 mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <select id="role" name="role" required class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 font-open-sans">
                            <option value="">-- Selecciona --</option>
                            <option value="graduate" {{ old('role') == 'graduate' ? 'selected' : '' }}>Egresado</option>
                            <option value="employer" {{ old('role') == 'employer' ? 'selected' : '' }}>Empleador</option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('role')" class="mt-2 text-sm text-red-600 font-open-sans" />
                </div>

                {{-- Campos adicionales para Empleador --}}
                <div id="employerFields" style="display: none;">
                    <div class="mb-6">
                        <x-input-label for="company_name" :value="__('Nombre de la empresa')" class="block text-sm font-semibold text-gray-700 mb-2 font-montserrat" />
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                </svg>
                            </div>
                            <x-text-input id="company_name" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 placeholder-gray-400 font-open-sans"
                                type="text" name="company_name" :value="old('company_name')" placeholder="Nombre de la empresa" />
                        </div>
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2 text-sm text-red-600 font-open-sans" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="contact_name" :value="__('Nombre del contacto')" class="block text-sm font-semibold text-gray-700 mb-2 font-montserrat" />
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <x-text-input id="contact_name" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 placeholder-gray-400 font-open-sans"
                                type="text" name="contact_name" :value="old('contact_name')" placeholder="Nombre de la persona de contacto" />
                        </div>
                        <x-input-error :messages="$errors->get('contact_name')" class="mt-2 text-sm text-red-600 font-open-sans" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="phone" :value="__('Teléfono')" class="block text-sm font-semibold text-gray-700 mb-2 font-montserrat" />
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 15a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <x-text-input id="phone" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 placeholder-gray-400 font-open-sans"
                                type="text" name="phone" :value="old('phone')" placeholder="Número de teléfono" />
                        </div>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2 text-sm text-red-600 font-open-sans" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="address" :value="__('Dirección')" class="block text-sm font-semibold text-gray-700 mb-2 font-montserrat" />
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <x-text-input id="address" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 placeholder-gray-400 font-open-sans"
                                type="text" name="address" :value="old('address')" placeholder="Dirección de la empresa" />
                        </div>
                        <x-input-error :messages="$errors->get('address')" class="mt-2 text-sm text-red-600 font-open-sans" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="website" :value="__('Sitio web')" class="block text-sm font-semibold text-gray-700 mb-2 font-montserrat" />
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 010-2.828z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <x-text-input id="website" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 placeholder-gray-400 font-open-sans"
                                type="url" name="website" :value="old('website')" placeholder="https://www.tuempresa.com" />
                        </div>
                        <p class="text-sm text-gray-500 mt-1 font-open-sans">
                            {{ __('Puedes dejar este campo vacío si no tienes sitio web') }}
                        </p>
                        <x-input-error :messages="$errors->get('website')" class="mt-2 text-sm text-red-600 font-open-sans" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="sector" :value="__('Sector')" class="block text-sm font-semibold text-gray-700 mb-2 font-montserrat" />
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1h4a1 1 0 011 1v4a1 1 0 01-1 1h-1.586l1.293 1.293a1 1 0 01-1.414 1.414l-2-2a1 1 0 010-1.414l2-2a1 1 0 011.414 0H16V6h-4V5a1 1 0 011-1 1 1 0 001-1V3a1 1 0 00-1-1zm-6 2a1 1 0 011-1h4a1 1 0 011 1v1h4a1 1 0 011 1v4a1 1 0 01-1 1h-1.586l1.293 1.293a1 1 0 01-1.414 1.414l-2-2a1 1 0 010-1.414l2-2a1 1 0 011.414 0H16V6h-4V5a1 1 0 011-1 1 1 0 001-1V3a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <x-text-input id="sector" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 placeholder-gray-400 font-open-sans"
                                type="text" name="sector" :value="old('sector')" placeholder="Por ejemplo: Tecnología, Educación" />
                        </div>
                        <x-input-error :messages="$errors->get('sector')" class="mt-2 text-sm text-red-600 font-open-sans" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="country" :value="__('País')" class="block text-sm font-semibold text-gray-700 mb-2 font-montserrat" />
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 6.027a8.001 8.001 0 0111.336 0L10 10.667 4.332 6.027z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <x-text-input id="country" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 placeholder-gray-400 font-open-sans"
                                type="text" name="country" :value="old('country')" placeholder="País donde se ubica la empresa" />
                        </div>
                        <x-input-error :messages="$errors->get('country')" class="mt-2 text-sm text-red-600 font-open-sans" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="city" :value="__('Ciudad')" class="block text-sm font-semibold text-gray-700 mb-2 font-montserrat" />
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 6.027a8.001 8.001 0 0111.336 0L10 10.667 4.332 6.027z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <x-text-input id="city" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 placeholder-gray-400 font-open-sans"
                                type="text" name="city" :value="old('city')" placeholder="Ciudad donde se ubica la empresa" />
                        </div>
                        <x-input-error :messages="$errors->get('city')" class="mt-2 text-sm text-red-600 font-open-sans" />
                    </div>
                </div>

                {{-- Botón de registro --}}
                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-blue-800 rounded-md
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 font-open-sans transition duration-150 ease-in-out"
                        href="{{ route('login') }}">
                        {{ __('¿Ya tienes una cuenta?') }}
                    </a>

                    <button type="submit"
                        class="ml-4 flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-md text-base font-semibold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200 ease-in-out transform hover:scale-[1.01] font-montserrat">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Registrarse') }}
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

<script>
    function toggleEmployerFields() {
        const roleSelect = document.getElementById('role');
        const employerFields = document.getElementById('employerFields');
        if (roleSelect.value === 'employer') {
            employerFields.style.display = 'block';
        } else {
            employerFields.style.display = 'none';
        }
    }

    document.getElementById('role').addEventListener('change', toggleEmployerFields);

    window.onload = function() {
        toggleEmployerFields();
    }
</script>
