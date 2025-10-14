<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Carbon\CarbonPeriod;
use Livewire\Attributes\Computed;
use Carbon\Carbon;
use App\Models\Speciality;
use Illuminate\Validation\Rule;
use App\Services\AppointmentService;

class AppointmentManager extends Component
{
    public $search = [
        'date' => '',
        'hour' => '',
        'speciality_id' => null,
    ];

    public $selectedSchedules = [
        'doctor_id' => '',
        'schedules' => [],
    ];

    public $specialities = [];

    public $availabilities = [];

    public $appointment = [
        'patient_id' => '',
        'doctor_id' => '',
        'date' => '',
        'start_time' => '',
        'end_time' => '',
        'duration' => '',
        'reason' => '',
    ];

    public function mount()
    {
        $this->specialities = Speciality::all();
        $this->search['date'] = now()->hour >= 12
            ? now()->addDay()->format('Y-m-d')
            : now()->format('Y-m-d');
    }

    #[Computed()]
    public function hourBlocks()
    {
        return CarbonPeriod::create(
            Carbon::createFromTimeString(config('schedule.start_time')),
            '1 hour',
            Carbon::createFromTimeString(config('schedule.end_time')),
        )->excludeEndDate();
    }

    public function searchAvailability(AppointmentService $service)
    {
        $this->validate([
            'search.date' => 'required|date|after_or_equal:today',
            'search.hour' => [
                'required',
                'date_format:H:i:s',
                Rule::when($this->search['date'] === now()->format('Y-m-d'), [
                    'after_or_equal:' . now()->format('H:i:s')
                ]),
            ],
            // ✅ ahora es opcional
            'search.speciality_id' => 'nullable|exists:specialities,id',
        ]);

        $this->appointment['date'] = $this->search['date'];

        // 🔍 Ejecutar búsqueda
        $this->availabilities = $service->searchAvailability(
            $this->search['date'],
            $this->search['hour'],
            $this->search['speciality_id']
        );

        // Puedes ver qué llega aquí:
        // dd($this->search, $availability);

        $this->dispatch('setSearch', $this->search);
    }

    public function render()
    {
        return view('livewire.admin.appointment-manager');
    }
}
