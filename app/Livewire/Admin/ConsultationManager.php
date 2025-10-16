<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Consultation;
use Livewire\Component;

class ConsultationManager extends Component
{
    public Appointment $appointment;
    public ?Consultation $consultation = null;

    public $form = [];

    public function mount(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->consultation = $appointment->consultation; // Puede ser null

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
            'form.diagnosis' => 'required|string|max:255',
            'form.treatment' => 'required|string|max:255',
            'form.notes' => 'nullable|string|max:255',
            'form.prescriptions' => 'required|array|min:1',
            'form.prescriptions.*.medicine' => 'required|string|max:255',
            'form.prescriptions.*.dosage' => 'required|string|max:255',
            'form.prescriptions.*.frequency' => 'required|string|max:255',
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
