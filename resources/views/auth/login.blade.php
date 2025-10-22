<x-guest-layout>
    <div class="min-h-screen flex">
        <!-- Columna izquierda (Formulario) -->
        <div class="w-full md:w-1/2 flex flex-col justify-center items-center px-8 md:px-16 bg-white">
            <div class="w-full max-w-md">
                <h1 class="text-2xl font-semibold text-gray-800 text-center mb-6">
                    DERMATOLOGÍA CLÍNICA INTEGRAL
                </h1>

                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex flex-col items-center mb-6">
                        <x-authentication-card-logo class="mb-3" />
                        <h2 class="text-xl font-semibold text-gray-800">Inicia sesión</h2>
                    </div>

                    <x-validation-errors class="mb-4" />

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <x-label for="email" value="Correo electrónico" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                placeholder="Ingrese su dirección de correo electrónico" :value="old('email')" required autofocus autocomplete="username" />
                        </div>

                        <div class="mb-4">
                            <x-label for="password" value="Contraseña" />
                            <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                                placeholder="Ingrese su contraseña" required autocomplete="current-password" />
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <label for="remember_me" class="flex items-center">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="ms-2 text-sm text-gray-600">Recordarme</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-indigo-600 hover:text-indigo-800" href="{{ route('password.request') }}">
                                    ¿Olvidó su contraseña?
                                </a>
                            @endif
                        </div>

                        <x-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-700 transition-all duration-200">
                            Continuar →
                        </x-button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Columna derecha (Imagen de fondo) -->
        <div class="hidden md:block w-3/4 relative">
            <img src="{{ asset('images/home2.png') }}" 
                 alt="Dermatología clínica Integral"
                 class="absolute inset-0 w-full h-full object-cover" />
            <div class="absolute inset-0 bg-black/10"></div>
        </div>
    </div>
</x-guest-layout>
