<div class="m-8 animate-fade-in">
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <x-wire-card class="md:col-span-2 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
            <p class="text-2xl font-bold text-gray-800">
                Buen día, Dra. {{ auth()->user()->name }}!
            </p>
            <p class="mt-1 text-gray-600">
                Aquí está el resumen de su jornada
            </p>
        </x-wire-card>

        <x-wire-card class="transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
            <p class="text-sm font-semibold text-gray-500">Citas para hoy</p>
            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ $data['appointments_today_count'] }}
            </p>
        </x-wire-card>

        <x-wire-card class="transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
            <p class="text-sm font-semibold text-gray-500">Citas para la semana</p>
            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ $data['appointments_week_count'] }}
            </p>
        </x-wire-card>
    </div>

    <div class="grid grid-cols-3 gap-8 animate-slide-up">
        <div>
            <x-wire-card class="transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                <p class="text-lg font-semibold text-gray-900">
                    Próxima cita:
                </p>

                @if ($data['next_appointment'])
                    <p class="mt-4 font-semibold text-xl text-gray-800">
                        {{ $data['next_appointment']->patient->user->name }}
                    </p>
                    <p class="text-gray-600 mb-4">
                        {{ $data['next_appointment']->date->format('d/m/Y') }} a las {{ $data['next_appointment']->start_time->format('H:i A') }}
                    </p>
                    <x-wire-button href="{{ route('admin.appointments.consultation', $data['next_appointment']) }}" 
                        class="w-full mt-3 transition-transform transform hover:scale-105">
                        Gestionar cita
                    </x-wire-button>
                @else
                    <p class="mt-4 text-gray-500">
                        No tienes citas programadas para hoy
                    </p>
                @endif
            </x-wire-card>
        </div>

        <div class="md:col-span-2">
            <x-wire-card class="transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                <p class="text-lg font-semibold text-gray-900">Agenda para hoy</p>
                <ul class="mt-4 divide-y divide-gray-200">
                    @forelse ($data['appointments_today'] as $appointment)
                        <li class="py-2 flex justify-between items-center transition-all duration-200 hover:bg-indigo-50 rounded-lg px-2">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $appointment->patient->user->name }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $appointment->date->format('d/m/Y') }} a las {{ $appointment->start_time->format('h:i A') }}
                                </p>
                            </div>
                            <a href="{{ route('admin.appointments.consultation', $appointment) }}" 
                               class="text-sm text-indigo-600 hover:text-indigo-800 transition-all duration-200">
                                Gestionar →
                            </a>
                        </li>
                    @empty
                        <li class="py-2">
                            <p class="text-gray-500">No tienes citas programadas para hoy.</p>
                        </li>
                    @endforelse
                </ul>
            </x-wire-card>
        </div>
    </div>
</div>

<!-- Animaciones Tailwind personalizadas -->
<style>
    @keyframes fade-in {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slide-up {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
    animation: fade-in 0.8s ease-out;
    }
    .animate-slide-up {
    animation: slide-up 0.9s ease-out;
    }
</style>
<div class="flex flex-col items-center mt-12">
  <h2 class="text-2xl font-bold text-gray-800 mb-8">
    Mis redes sociales
  </h2>

  <div class="flex flex-wrap justify-center gap-8">
    <!-- TikTok -->
    <a href="https://www.tiktok.com/@dra_brunella_raymundo" target="_blank"
       class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 overflow-hidden w-56">
      <div class="absolute inset-0 bg-gradient-to-tr from-black via-gray-800 to-gray-700 opacity-10 group-hover:opacity-20 transition duration-300"></div>
      <div class="flex flex-col items-center justify-center p-6">
        <img src="https://cdn-icons-png.flaticon.com/512/3046/3046126.png" alt="TikTok"
             class="w-14 h-14 mb-3 group-hover:scale-110 transition-transform duration-300">
        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-black">TikTok</h3>
      </div>
    </a>

    <!-- Instagram -->
    <a href="https://www.instagram.com/dra_brunella_raymundo/" target="_blank"
       class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 overflow-hidden w-56">
      <div class="absolute inset-0 bg-gradient-to-tr from-pink-400 via-red-400 to-yellow-400 opacity-10 group-hover:opacity-20 transition duration-300"></div>
      <div class="flex flex-col items-center justify-center p-6">
        <img src="https://cdn-icons-png.flaticon.com/512/174/174855.png" alt="Instagram"
             class="w-14 h-14 mb-3 group-hover:scale-110 transition-transform duration-300">
        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-pink-500">Instagram</h3>
      </div>
    </a>

    <!-- Facebook -->
    <a href="https://www.facebook.com/p/Dra-Brunella-Raymundo-100094456022644/" target="_blank"
       class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 overflow-hidden w-56">
      <div class="absolute inset-0 bg-gradient-to-tr from-blue-500 to-blue-300 opacity-10 group-hover:opacity-20 transition duration-300"></div>
      <div class="flex flex-col items-center justify-center p-6">
        <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook"
             class="w-14 h-14 mb-3 group-hover:scale-110 transition-transform duration-300">
        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600">Facebook</h3>
      </div>
    </a>

    <!-- LinkedIn -->
    <a href="https://www.linkedin.com/in/brunella-raymundo-villalva-74bb67b3" target="_blank"
       class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 overflow-hidden w-56">
      <div class="absolute inset-0 bg-gradient-to-tr from-blue-600 to-cyan-400 opacity-10 group-hover:opacity-20 transition duration-300"></div>
      <div class="flex flex-col items-center justify-center p-6">
        <img src="https://cdn-icons-png.flaticon.com/512/174/174857.png" alt="LinkedIn"
             class="w-14 h-14 mb-3 group-hover:scale-110 transition-transform duration-300">
        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-700">LinkedIn</h3>
      </div>
    </a>
  </div>
</div>


</div>