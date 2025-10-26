<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder;

class AppointmentTable extends DataTableComponent
{
    // protected $model = Appointment::class;
    public function builder(): Builder
    {
        return Appointment::query()
            ->with('patient.user', 'doctor.user');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchPlaceholder('Buscar por Nombre');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Paciente", "patient.user.name")
                ->sortable()->searchable(),
            // Column::make("Doctor", "doctor.user.name")
            //     ->sortable(),
            Column::make("Fecha", "date")
                ->format(function($value) {
                    return $value->format('d/m/Y');
                })
                ->sortable(),
            Column::make("Hora Inicio", "start_time")
                ->format(function($value) {
                    return $value->format('H:i');
                })
                ->sortable(),
            Column::make("Hora fin", "end_time")
                ->format(function($value) {
                    return $value->format('H:i');
                })
                ->sortable(),
            Column::make("Estado", "status")
    ->format(function ($value, $row) {
        $color = $value->colorHex();
        $label = $value->label();

        return <<<HTML
            <span style="
                background-color: {$color};
                color: white;
                padding: 4px 8px;
                border-radius: 6px;
                font-size: 0.85rem;
                font-weight: 600;
                text-transform: capitalize;
            ">
                {$label}
            </span>
        HTML;
    })
    ->html(),
            Column::make("Acciones")
                ->label(function($row){
                    return view('admin.appointments.actions', ['appointment' => $row]);
                }
                ),
        ];
    }
}
