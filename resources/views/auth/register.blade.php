<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50 p-4 sm:p-0"
        style="background-image: url('https://tecnologicosucre.edu.ec/web/assets/images/bg-login.jpg'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat;">

        <div class="w-full sm:max-w-md flex flex-col items-center mb-6">
            <h1
                class="text-center text-white bg-blue-institutional px-5 py-3 rounded-xl shadow-primary mt-4 font-montserrat tracking-wide leading-tight">
                <span class="block text-2xl sm:text-3xl font-extrabold mb-1">Registro de Usuarios - SEI</span>
                <span class="block text-xs sm:text-sm font-normal opacity-80 mt-1">Únete a nuestra comunidad de egresados
                    y empleadores</span>
            </h1>
        </div>

        <div
            class="w-full sm:max-w-md px-6 py-8 bg-white bg-opacity-80 backdrop-blur-sm rounded-xl border border-primary-lightest shadow-2xl overflow-hidden transform transition-all duration-300 hover:scale-[1.01] hover:shadow-3xl">

            @if ($errors->any())
                <div class="mb-6 px-4 py-3 bg-red-50 text-red-800 rounded-lg border border-red-200 text-base font-open-sans"
                    role="alert" aria-live="assertive">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" novalidate id="registerForm">
                @csrf

                {{-- Nombre completo --}}
                <div class="mb-6">
                    <x-input-label for="name" :value="__('Nombre completo')"
                        class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <x-text-input id="name" name="name" type="text" :value="old('name')" required autofocus
                            autocomplete="name" placeholder="Tu nombre completo"
                            class="block w-full pl-10 pr-3 py-2 border border-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary placeholder-gray-400 font-open-sans" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600 font-open-sans" />
                </div>

                {{-- Correo electrónico --}}
                <div class="mb-6">
                    <x-input-label for="email" :value="__('Correo electrónico')"
                        class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <x-text-input id="email" name="email" type="email" :value="old('email')" required
                            autocomplete="username" placeholder="usuario@tecnologicosucre.edu.ec"
                            class="block w-full pl-10 pr-3 py-2 border border-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary placeholder-gray-400 font-open-sans" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 font-open-sans" />
                </div>

                {{-- Contraseña --}}
                <div class="mb-6 relative">
                    <x-input-label for="password" :value="__('Contraseña')"
                        class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <x-text-input id="password" name="password" type="password" required
                            autocomplete="new-password" placeholder="••••••••"
                            class="block w-full pl-10 pr-12 py-2 border border-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary placeholder-gray-400 font-open-sans" />
                        <button type="button" id="btn-show-password" aria-label="Mostrar contraseña"
                            title="Mantén presionado para ver contraseña"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-600 hover:text-blue-800 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="#0000FF" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 font-open-sans" />
                </div>

                {{-- Confirmar contraseña --}}
                <div class="mb-6 relative">
                    <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')"
                        class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" required
                            autocomplete="new-password" placeholder="••••••••"
                            class="block w-full pl-10 pr-12 py-2 border border-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary placeholder-gray-400 font-open-sans" />
                        <button type="button" id="btn-show-password-confirm" aria-label="Mostrar confirmar contraseña"
                            title="Mantén presionado para ver contraseña"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-600 hover:text-blue-800 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="#0000FF" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600 font-open-sans" />
                </div>

                {{-- Selección de rol --}}
                <div class="mb-6">
                    <x-input-label for="role" :value="__('Selecciona tu rol')"
                        class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <select id="role" name="role" required
                            class="block w-full pl-10 pr-3 py-2 border border-secondary rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary font-open-sans"
                            aria-describedby="roleHelp">
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Selecciona --
                            </option>
                            <option value="graduate" {{ old('role') === 'graduate' ? 'selected' : '' }}>Egresado
                            </option>
                            <option value="employer" {{ old('role') === 'employer' ? 'selected' : '' }}>Empleador
                            </option>
                        </select>
                    </div>
                    <p id="roleHelp" class="text-xs text-text-secondary mt-1">Elige si deseas registrarte como
                        egresado o empleador.</p>
                    <x-input-error :messages="$errors->get('role')" class="mt-2 text-sm text-red-600 font-open-sans" />
                </div>

                {{-- Campos para empleador, ocultos inicialmente --}}
                <div id="employerFields"
                    class="space-y-6 p-4 border border-primary-lightest rounded-lg bg-white bg-opacity-90 shadow-sm"
                    style="display: none;">
                    <h3 class="text-primary font-semibold mb-4 font-montserrat">Información para Empleador</h3>

                    {{-- company_name --}}
                    <div>
                        <x-input-label for="company_name" :value="__('Nombre de la empresa')"
                            class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                        <x-text-input id="company_name" name="company_name" type="text" :value="old('company_name')"
                            placeholder="Nombre de la empresa"
                            class="block w-full border border-secondary rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary font-open-sans" />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2 text-sm text-red-600 font-open-sans" />
                    </div>

                    {{-- contact_name --}}
                    <div>
                        <x-input-label for="contact_name" :value="__('Nombre de contacto')"
                            class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                        <x-text-input id="contact_name" name="contact_name" type="text" :value="old('contact_name')"
                            placeholder="Nombre de la persona de contacto"
                            class="block w-full border border-secondary rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary font-open-sans" />
                        <x-input-error :messages="$errors->get('contact_name')" class="mt-2 text-sm text-red-600 font-open-sans" />
                    </div>

                    {{-- ruc --}}
                    <div>
                        <x-input-label for="ruc" :value="__('RUC de la empresa')"
                            class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                        <x-text-input id="ruc" name="ruc" type="text" :value="old('ruc')"
                            placeholder="Ejemplo: 1790012345001"
                            class="block w-full border border-secondary rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary font-open-sans" />
                        <x-input-error :messages="$errors->get('ruc')" class="mt-2 text-sm text-red-600 font-open-sans" />
                    </div>

                    {{-- phone --}}
                    <div>
                        <x-input-label for="phone" :value="__('Teléfono')"
                            class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                        <x-text-input id="phone" name="phone" type="tel" :value="old('phone')"
                            placeholder="+593 9 1234 5678"
                            class="block w-full border border-secondary rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary font-open-sans" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2 text-sm text-red-600 font-open-sans" />
                    </div>

                    {{-- address --}}
                    <div>
                        <x-input-label for="address" :value="__('Dirección')"
                            class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                        <x-text-input id="address" name="address" type="text" :value="old('address')"
                            placeholder="Dirección de la empresa"
                            class="block w-full border border-secondary rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary font-open-sans" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2 text-sm text-red-600 font-open-sans" />
                    </div>

                    {{-- website --}}
                    <div>
                        <x-input-label for="website" :value="__('Sitio web (opcional)')"
                            class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                        <x-text-input id="website" name="website" type="url" :value="old('website')"
                            placeholder="https://www.ejemplo.com"
                            class="block w-full border border-secondary rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary font-open-sans" />
                        <p class="text-xs text-text-secondary mt-1">Puedes dejarlo vacío si no tienes sitio web.</p>
                        <x-input-error :messages="$errors->get('website')" class="mt-2 text-sm text-red-600 font-open-sans" />
                    </div>


                    {{-- sector --}}
                    <div>
                        <x-input-label for="sector" :value="__('Sector')"
                            class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                        <x-text-input id="sector" name="sector" type="text" :value="old('sector')"
                            placeholder="Ejemplo: Tecnología, Salud, Finanzas"
                            class="block w-full border border-secondary rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary font-open-sans" />
                        <x-input-error :messages="$errors->get('sector')" class="mt-2 text-sm text-red-600 font-open-sans" />
                    </div>

                    {{-- country --}}
                    <div>
                        <x-input-label for="country" :value="__('País')"
                            class="block text-sm font-semibold text-text-secondary mb-2 font-montserrat" />
                        <x-text-input id="country" name="country" type="text" :value="old('country')"
                            placeholder="Ejemplo: Ecuador"
                            class="block w-full border border-secondary rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary font-open-sans" />
                        <x-input-error :messages="$errors->get('country')" class="mt-2 text-sm text-red-600 font-open-sans" />
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg shadow-md transition duration-300 ease-in-out font-open-sans">
                        Registrarse
                    </button>
                </div>

                <div class="mt-6 text-center text-sm text-gray-600 font-open-sans">
                    ¿Ya tienes una cuenta?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                        Inicia sesión
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const roleSelect = document.getElementById('role');
            const employerFields = document.getElementById('employerFields');
            const rucInput = document.getElementById('ruc');
            const registerForm = document.getElementById('registerForm');

            function toggleEmployerFields() {
                if (roleSelect.value === 'employer') {
                    employerFields.style.display = 'block';
                    rucInput.setAttribute('required', 'required');
                } else {
                    employerFields.style.display = 'none';
                    rucInput.removeAttribute('required');
                }
            }

            roleSelect.addEventListener('change', toggleEmployerFields);

            // Inicializar al cargar la página
            toggleEmployerFields();

            // Opcional: validación sencilla antes de enviar
            registerForm.addEventListener('submit', (e) => {
                if (roleSelect.value === 'employer') {
                    if (!rucInput.value.trim()) {
                        e.preventDefault();
                        alert('El campo RUC es obligatorio para empleadores.');
                        rucInput.focus();
                    }
                }
            });

            // Opcional: botones para mostrar/ocultar contraseña
            const btnShowPassword = document.getElementById('btn-show-password');
            const passwordInput = document.getElementById('password');
            btnShowPassword.addEventListener('mousedown', () => {
                passwordInput.type = 'text';
            });
            btnShowPassword.addEventListener('mouseup', () => {
                passwordInput.type = 'password';
            });
            btnShowPassword.addEventListener('mouseout', () => {
                passwordInput.type = 'password';
            });

            const btnShowPasswordConfirm = document.getElementById('btn-show-password-confirm');
            const passwordConfirmInput = document.getElementById('password_confirmation');
            btnShowPasswordConfirm.addEventListener('mousedown', () => {
                passwordConfirmInput.type = 'text';
            });
            btnShowPasswordConfirm.addEventListener('mouseup', () => {
                passwordConfirmInput.type = 'password';
            });
            btnShowPasswordConfirm.addEventListener('mouseout', () => {
                passwordConfirmInput.type = 'password';
            });
        });
    </script>
</x-guest-layout>
