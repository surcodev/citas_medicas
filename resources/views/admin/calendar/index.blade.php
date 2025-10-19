<x-admin-layout
    title="Calendario"
    :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Calendario',
    ]
    ]"
    >

    @push('css')
        <style>
            .fc-event {
                cursor: pointer;
            }
        </style>
    @endpush

    <div x-data="data()">
        <x-wire-modal-card
            title="Cita médica"
            name="appointmentModal"
            width="md"
            align="center">

            <div class="space-y-4 mb-4">
                <div>
                    <strong>Fecha y hora:</strong>
                    <p x-text="selectedEvent.dateTime"></p>
                </div>
                <div>
                    <strong>Paciente:</strong>
                    <p x-text="selectedEvent.patient"></p>
                </div>
                <div>
                    <strong>Doctor:</strong>
                    <p x-text="selectedEvent.doctor"></p>
                </div>
                <div>
                    <strong>Estado:</strong>
                    <p x-text="selectedEvent.status"></p>
                </div>
            </div>

            <a x-bind:href="selectedEvent.url" class="w-full">
                <x-wire-button class="w-full">
                    Gestionar cita
                </x-wire-button>
            </a>

        </x-wire-modal-card>
        <div x-ref='calendar'></div>
    </div>

    @push('js')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>

        <script>
            function data() {
                return {

                    selectedEvent: {
                        dateTime: null,
                        patient: null,
                        doctor: null,
                        status: null,
                        color: null,
                        url: null,
                    },

                    openModal(info) {
                        this.selectedEvent = {
                            dateTime: info.event.start.toLocaleString(),
                            patient: info.event.extendedProps.patient,
                            doctor: info.event.extendedProps.doctor,
                            status: info.event.extendedProps.status,
                            color: info.event.backgroundColor,
                            url: info.event.extendedProps.url,
                        };
                        console.log(this.selectedEvent);
                        
                        $openModal('appointmentModal');
                    },

                    init() {
                        var calendarEl = this.$refs.calendar;
                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,listWeek'
                            },
                            initialView: 'dayGridMonth',
                            locale: 'es',
                            buttonText: {
                                today: 'Hoy',
                                month: 'Mes',
                                week: 'Semana',
                                day: 'Día',
                                list: 'Lista'
                            },
                            allDayText: 'Todo el día',
                            noEventsText: 'No hay eventos para mostrar',
                            slotDuration: '00:30:00',
                            slotMinTime: "{{ config('schedule.start_time') }}",
                            slotMaxTime: "{{ config('schedule.end_time') }}",
                            scrollTime: "{{ date('H:i:s') }}",

                            events: {
                                url: '{{ route('api.appointments.index') }}',
                                failure: function() {
                                    alert('Hubo un error al cargar los elementos!');
                                },
                            },
                            eventClick: (info) => this.openModal(info),
                            scrollTime: "{{ date('H:i:s') }}",
                        });
                        calendar.render();
                    }
                };
            }
        </script>
    @endpush

</x-admin-layout>
    