<div x-data="data()">
    <x-wire-card class="mb-8">
        <p class="text-xl font-semibold mb-1 text-slate-800">
            Buscar disponibilidad
        </p>
        <p>
            Encuentra el horario perfecto para tu cita.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <x-wire-input
                type="date"
                label="Fecha"
                wire:model="search.date"
                class="col-span-2"
                placeholder="Selecciona una fecha"
            />

            <x-wire-select
                label="Hora"
                wire:model="search.hour"
                placeholder="Selecciona una hora"
            >
                @foreach ($this->hourBlocks as $hourBlock)
                    <x-wire-select.option
                        :label="$hourBlock->format('H:i:s') . ' - ' . $hourBlock->copy()->addHour()->format('H:i:s')"
                        :value="$hourBlock->format('H:i:s')" />
                @endforeach
            </x-wire-select>

            <x-wire-select
            class="hidden"
                label="Especialidad (opcional)"
                wire:model="search.speciality_id"
                placeholder="Selecciona una especialidad"
            >
                @foreach ($specialities as $speciality)
                    <x-wire-select.option
                        :label="$speciality->name"
                        :value="$speciality->id" />
                @endforeach
            </x-wire-select>

            <div class="">
                <x-wire-button
                    wire:click="searchAvailability"
                    class="w-full mt-6"
                    color="primary"
                    :disabled="$appointmentEdit && !$appointmentEdit->status->isEditable()">
                    Buscar disponibilidad
                </x-wire-button>
            </div>
        </div>
    </x-wire-card>

    @if ($appointment['date'])
        @if (count($availabilities))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8">
                <div class="col-span-1 md:col-span-2 space-y-6">

                    @foreach ($availabilities as $availability)
                        <x-wire-card>
                            <div class="flex items-center space-x-4">
                                <img src="{{ $availability['doctor']->user->profile_photo_url }}" alt="{{ $availability['doctor']->user->name }}" class="w-16 h-16 rounded-full object-cover flex-shrink-0 mr-4">

                                <div>
                                    <p class="text-xl font-bold text-slate-800">
                                        {{ $availability['doctor']->user->name }}
                                    </p>

                                    <p class="text-sm text-indigo-600 font-medium">
                                        {{ $availability['doctor']->speciality?->name ?? 'Sin especialidad' }}
                                    </p>
                                </div>

                            </div>

                            <hr class="my-5">

                            <div>
                                <p class="text-sm text-slate-600 mb-2 font-semibold">
                                    Horarios disponibles:
                                </p>

                                <ul class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                    @foreach ($availability['schedules'] as $schedule)
                                        <li>
                                            <x-wire-button
                                                :disabled="$schedule['disabled']"
                                                :color="$schedule['disabled'] ? 'secondary' : 'primary'"
                                                x-on:click="selectSchedule({{ $availability['doctor']->id }}, '{{ $schedule['start_time'] }}')"
                                                x-bind:class="selectedSchedules.doctor_id === {{ $availability['doctor']->id }} && selectedSchedules.schedules.includes('{{ $schedule['start_time'] }}') ? 'opacity-50' : ''"
                                                class="w-full">
                                                {{ \Carbon\Carbon::parse($schedule['start_time'])->format('H:i') }} -
{{ \Carbon\Carbon::parse($schedule['start_time'])->addMinutes(30)->format('H:i') }}

                                            </x-wire-button>

                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        </x-wire-card>
                    @endforeach

                </div>

                <div class="col-span-1">
                    {{-- @json($selectedSchedules) --}}
                    <x-wire-card>
                        <p class="text-lg font-semibold mb-4 text-slate-800">
                            Resumen de la cita
                        </p>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="font-slate-500">
                                    Doctor:
                                </span>
                                <span class="font-semibold font-slate-700">
                                    {{ $this->doctorName }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="font-slate-500">
                                    Fecha:
                                </span>
                                <span class="font-semibold font-slate-700">
                                    {{ $appointment['date']->format('d/m/Y') }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="font-slate-500">
                                    Horario:
                                </span>
                                <span class="font-semibold font-slate-700">
                                    @if ($appointment['duration'])
                                        {{ $appointment['start_time'] }} - {{ $appointment['end_time'] }}
                                    @else
                                        Por definir
                                    @endif
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="font-slate-500">
                                    Duración:
                                </span>
                                <span class="font-semibold font-slate-700">
                                    {{ $appointment['duration'] ?: 0 }} minutos
                                </span>
                            </div>

                        </div>

                        <hr class="my-3">

                        <div class="space-y-6">
                            <x-wire-select
                                label="Paciente"
                                placeholder="Selecciona un paciente"
                                :async-data="route('api.patients.index')"
                                wire:model="appointment.patient_id"
                                :disabled="isset($appointmentEdit)"
                                option-label="name"
                                option-value="id"
                            />

                            <x-wire-textarea 
                                wire:model="appointment.reason"
                                label="Motivo de la cita"
                                placeholder="Ingrese el motivo de la cita"
                            />

                            <x-wire-button
                                wire:click="save"
                                spinner="save"
                                class="w-full">
                                Confirmar cita
                            </x-wire-button>
                            
                        </div>

                    </x-wire-card>
                </div>
            </div>
        @else
            <x-wire-card>
                <p>
                    No hay disponibilidad para la fecha y hora seleccionada.
                </p>
            </x-wire-card>
        @endif
    @endif

    @push('js')
        <script>
            function data(){
                return {
                    selectedSchedules: @entangle('selectedSchedules').live,

                    selectSchedule(doctorId, schedule) {
                        if (this.selectedSchedules.doctor_id !== doctorId) {
                            this.selectedSchedules = {
                                doctor_id: doctorId,
                                schedules: [schedule]
                            };
                            return;
                        }

                        let currentSchedules = this.selectedSchedules.schedules;
                        let newSchedules = [];

                        if (currentSchedules.includes(schedule)) {
                            newSchedules = currentSchedules.filter(s => s !== schedule);
                        } else {
                            newSchedules = [...currentSchedules, schedule];
                        }

                        if (this.isContiguos(newSchedules)) {
                            this.selectedSchedules = {
                                doctor_id: doctorId,
                                schedules: newSchedules
                            };
                        } else {
                            this.selectedSchedules = {
                                doctor_id: doctorId,
                                schedules: [schedule]
                            };
                        }
                    },

                    isContiguos(schedules) {
                        if (schedules.length <= 1) return true;

                        let sortedSchedules = schedules.sort();

                        for (let i = 0; i < sortedSchedules.length - 1; i++) {
                            let currentTime = sortedSchedules[i];
                            let nextTime = sortedSchedules[i + 1];

                            if (this.calculateNextTime(currentTime) !== nextTime) {
                                return false;
                            }
                        }

                        return true;
                    },

                    calculateNextTime(time) {
                        let date = new Date(`1970-01-01T${time}`);
                        let duration = parseInt("{{ config('schedule.appointment_duration') ?? 15 }}");
                        date.setMinutes(date.getMinutes() + duration);
                        return date.toTimeString().split(' ')[0];
                    }
                }
            }
        </script>
    @endpush


</div>
