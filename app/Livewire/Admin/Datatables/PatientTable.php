<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder;

class PatientTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Patient::query()->with('user');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchPlaceholder('Buscar paciente por nombre');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')->sortable(),
            Column::make('Nombre', 'user.name')->sortable()->searchable(),
            Column::make('Email', 'user.email')->sortable(),
            Column::make('DNI', 'user.dni')->sortable(),
            Column::make('Teléfono', 'user.phone')->sortable(),
            Column::make("Editar")
                ->label(function($row){
                    return view('admin.patients.actions', ['patient' => $row]);
                }
                ),
            
        ];
    }
}
