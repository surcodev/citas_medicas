<div>
    <div class="grid grid-cols-4 gap-6 mb-8">
            <x-wire-card class="col-span-2">
                <p class="text-2xl font-bold text-gray-800">
                    Buen dia, Dr(a). {{ auth()->user()->name }}!
                </p>
                <p class="mt-1 text-gray-600">
                    Aquí esta el resumen de su jornada
                </p>
            </x-wire-card>

            <x-wire-card>
                <p class="text-sm font-semibold text-gray-500">
                        Citas para hoy
                </p>
                <p class="mt-2 text-3xl font-bold text-gray-800">
                    {{ $data['appointments_today_count'] }}
                </p>
            </x-wire-card>

            <x-wire-card>
                <p class="text-sm font-semibold text-gray-500">
                        Citas para la semana
                </p>
                <p class="mt-2 text-3xl font-bold text-gray-800">
                    {{ $data['appointments_week_count'] }}
                </p>
            </x-wire-card>
    </div>

    <div class="grid grid-cols-3 gap-8">
        <div>
            <x-wire-card>
                <p class="text-lg font-semibold text-gray-900">
                    Próxima cita:
                </p>

                @if ($data['next_appointment'])
                    <p class="mt-4 font-semibold text-xl text-gray-800">
                        {{ $data['next_appointment']->patient->user->name }}
                    </p>
                    <p>
                        {{ $data['next_appointment']->date->format('d/m/Y') }} a las {{ $data['next_appointment']->start_time->format('H:i A') }}
                    </p>
                @else
                    <p class="mt-2 text-gray-600">
                        <p class="mt-4 text-gray-500">
                            No tienes citas programadas para hoy
                        </p>
                    </p>
                @endif

            </x-wire-card>
        </div>
        <div class="col-span-2">
        </div>
    </div>
</div>