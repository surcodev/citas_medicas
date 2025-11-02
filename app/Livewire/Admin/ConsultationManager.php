<?php

namespace App\Livewire\Admin;

use App\Enums\AppointmentEnum;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Patient;
use Livewire\Component;

class ConsultationManager extends Component
{
    public Appointment $appointment;
    public ?Consultation $consultation = null;
    public $previousConsultations;
    public Patient $patient;

    public $form = [];

    public function mount(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->consultation = $appointment->consultation; // Puede ser null
        $this->patient = $appointment->patient;

        // ✅ Manejar el caso cuando aún no hay consulta
        $this->form = [
            'diagnosis' => $this->consultation->diagnosis ?? '',
            'treatment' => $this->consultation->treatment ?? '',
            'notes' => $this->consultation->notes ?? '',
            'prescriptions' => $this->consultation->prescriptions ?? [
                [
                    'medicine' => '',
                    'dosage' => '',
                    'frequency' => '',
                ]
            ],
        ];

        $this->previousConsultations = Consultation::whereHas('appointment', function ($query) {
            $query->where('patient_id', $this->patient->id);
        })
        ->where('id', '!=', $this->consultation?->id)
        ->when($this->consultation, function ($query) {
            $query->where('created_at', '<', $this->consultation->created_at);
        })
        ->latest()
        ->take(5)
        ->get();
    }

    public function addPrescription()
    {
        $this->form['prescriptions'][] = [
            'medicine' => '',
            'dosage' => '',
            'frequency' => '',
        ];
    }

    public function removePrescription($index)
    {
        unset($this->form['prescriptions'][$index]);
        $this->form['prescriptions'] = array_values($this->form['prescriptions']);
    }

    public function save()
    {
        $this->validate([
            'form.diagnosis' => 'string|max:500',
            'form.treatment' => 'string|max:500',
            'form.notes' => 'nullable|string|max:500',
            'form.prescriptions' => 'array|min:1',
            'form.prescriptions.*.medicine' => 'string|max:255',
            'form.prescriptions.*.dosage' => 'string|max:255',
            'form.prescriptions.*.frequency' => 'string|max:255',
        ]);

        // Si no existe consulta, la creamos
        if (!$this->consultation) {
            $this->consultation = Consultation::create([
                'appointment_id' => $this->appointment->id,
                'diagnosis' => $this->form['diagnosis'],
                'treatment' => $this->form['treatment'],
                'notes' => $this->form['notes'],
                'prescriptions' => $this->form['prescriptions'],
            ]);
        } else {
            // Si ya existe, actualizamos
            $this->consultation->update([
                'diagnosis' => $this->form['diagnosis'],
                'treatment' => $this->form['treatment'],
                'notes' => $this->form['notes'],
                'prescriptions' => $this->form['prescriptions'],
            ]);
        }

        $this->appointment->status = AppointmentEnum::COMPLETED;
        $this->appointment->save();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Consulta guardada correctamente',
            'text' => 'Los detalles de la consulta han sido guardados.',
        ]);
    }


    public function render()
    {
        return view('livewire.admin.consultation-manager');
    }
}
