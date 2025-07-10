<x-guest-layout>
    @php
        $errorMessage = $errors->has('email') ? $errors->first('email') : '';
        $bloqueado =
            $errorMessage &&
            \Illuminate\Support\Str::contains($errorMessage, ['Too many login attempts', 'Demasiados intentos']);

        preg_match('/(\d+)\s*segundos?/', $errorMessage, $matches);
        $segundosRestantes = $matches[1] ?? 0;
    @endphp


    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50 p-4 sm:p-0"
        style="background-image: url('https://tecnologicosucre.edu.ec/web/assets/images/bg-login.jpg'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat;">

        <div class="w-full sm:max-w-md flex flex-col items-center mb-6">
            <img src="https://tecnologicosucre.edu.ec/web/wp-content/uploads/2023/08/OP1-mod.png"
                alt="Logo Instituto Tecnológico Sucre" class="h-24 sm:h-28 mb-6 drop-shadow-lg">

            <h1
                class="text-center text-white bg-blue-institutional px-5 py-3 rounded-xl shadow-primary mt-4 font-montserrat tracking-wide leading-tight">
                <span class="block text-2xl sm:text-3xl font-extrabold mb-1">Sistema de Egresados Institucional -
                    SEI</span>
                <span class="block text-xs sm:text-sm font-normal opacity-80 mt-1">Conectando la formación académica con
                    el futuro profesional</span>
            </h1>
        </div>

        <div
            class="w-full sm:max-w-md px-6 py-8 bg-white shadow-2xl rounded-xl overflow-hidden backdrop-blur-sm bg-opacity-85 border border-primary-lightest transform transition-all duration-300 hover:scale-[1.01] hover:shadow-3xl">

            @if ($errors->has('email') && Str::contains($errors->first('email'), ['intentos', 'Too many login attempts']))
                <div class="mb-6 p-4 text-sm text-red-800 bg-red-100 border border-red-300 rounded-lg font-open-sans">
                    {{ $errors->first('email') }}
                </div>
            @endif

            <x-auth-session-status
                class="mb-6 px-4 py-3 bg-primary-lightest text-primary-dark rounded-lg border border-primary-light text-base font-open-sans"
                :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

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
                            type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                            placeholder="usuario@tecnologicosucre.edu.ec" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-error font-open-sans" />
                </div>

                <div class="mb-6">
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
                            type="password" name="password" required autocomplete="current-password"
                            placeholder="••••••••" />

                        <button type="button" id="btn-show-password" onmousedown="showPassword()"
                            onmouseup="hidePassword()" onmouseleave="hidePassword()"
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

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="h-4 w-4 text-primary focus:ring-primary border-secondary rounded-md cursor-pointer">
                        <label for="remember_me"
                            class="ml-2 block text-sm text-text-secondary font-open-sans cursor-pointer">Recordar
                            sesión</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-primary hover:text-primary-dark font-medium hover:underline font-open-sans transition duration-150 ease-in-out">
                            ¿Olvidó su contraseña?
                        </a>
                    @endif
                </div>

                @php
                    $errorMessage = $errors->has('email') ? $errors->first('email') : '';
                    $bloqueado =
                        $errorMessage &&
                        \Illuminate\Support\Str::contains($errorMessage, [
                            'Too many login attempts',
                            'Demasiados intentos',
                        ]);

                    preg_match('/(\d+)\s*segundos?/', $errorMessage, $matches);
                    $segundosRestantes = $matches[1] ?? 0;
                @endphp

                <div class="flex items-center justify-center">
                    <button id="btn-login" type="submit"
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-primary text-base font-semibold text-white font-montserrat
        transition duration-200 ease-in-out transform
        {{ $bloqueado ? 'bg-gray-400 cursor-not-allowed opacity-70' : 'bg-primary hover:bg-primary-dark hover:scale-[1.01] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary' }}"
                        {{ $bloqueado ? 'disabled' : '' }}>
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>

                        <span id="btn-text">
                            {{ $bloqueado ? "Bloqueado temporalmente ({$segundosRestantes}s)" : 'Iniciar Sesión' }}
                        </span>
                    </button>
                </div>

                @if ($bloqueado && $segundosRestantes > 0)
                    <script>
                        let segundos = {{ $segundosRestantes }};
                        const btnText = document.getElementById('btn-text');
                        const btnLogin = document.getElementById('btn-login');

                        const intervalo = setInterval(() => {
                            segundos--;
                            if (segundos > 0) {
                                btnText.textContent = `Bloqueado temporalmente (${segundos}s)`;
                            } else {
                                btnText.textContent = 'Iniciar Sesión';
                                btnLogin.disabled = false;
                                btnLogin.classList.remove('bg-gray-400', 'cursor-not-allowed', 'opacity-70');
                                btnLogin.classList.add('bg-primary', 'hover:bg-primary-dark', 'hover:scale-[1.01]',
                                    'focus:outline-none', 'focus:ring-2', 'focus:ring-offset-2', 'focus:ring-primary');
                                clearInterval(intervalo);
                            }
                        }, 1000);
                    </script>
                @endif

            </form>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 text-center bg-white/90 rounded-lg shadow-lg border border-primary-lightest">
            <p class="text-sm text-text-secondary font-open-sans">
                © {{ date('Y') }} Instituto Superior Universitario Tecnológico Sucre
            </p>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const btnShowPassword = document.getElementById('btn-show-password');

        function showPassword() {
            passwordInput.type = 'text';
        }

        function hidePassword() {
            passwordInput.type = 'password';
        }

        passwordInput.addEventListener('blur', hidePassword);
    </script>
</x-guest-layout>
