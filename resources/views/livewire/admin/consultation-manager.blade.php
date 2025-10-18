<div>
    <div class="md:flex md:justify-between items-center mb-4">
                <div>
                        <p class="text-2xl font-bold text-gray-900 mb-1">
                            {{ $appointment->patient->user->name }}
                        </p>
                        <p class="text-smfont-semibold text-gray">
                            DNI: {{ $appointment->patient->user->dni ?? 'N/A' }}
                        </p>
                </div>
                <div class="flex space-x-8">
                    <x-wire-button outline gray x-on:click="$openModal('historyModal')">
                        <i class="fa-solid fa-notes-medical md"></i>
                        Ver historia
                    </x-wire-button>

                    <x-wire-button outline gray x-on:click="$openModal('previousConsultationsModal')">
                        <i class="fa-solid fa-clock-rotate-left md"></i>
                        Consultas anteriores
                    </x-wire-button>
                </div>
    </div>

    <x-wire-card>
        <x-tabs active="consulta">
            <x-slot name="header">
                    <x-tab-link tab="consulta">
                        <i class="fa-solid fa-file-medical me-2"></i>
                        Consulta
                    </x-tab-link>

                    <x-tab-link tab="receta">
                            <i class="fa-solid fa-prescription-bottle-medical me-2"></i>
                            Receta
                    </x-tab-link>
            </x-slot>
                <x-tab-content tab="consulta">
                    <div class="space-y-4">
                        <x-wire-textarea 
                            label="Diagnóstico" 
                            placeholder="Describa diagnóstico del paciente aquí..."
                            wire:model.defer="form.diagnosis"
                        />

                        <x-wire-textarea 
                            label="Tratamiento" 
                            placeholder="Describa el tratamiento aquí..."
                            wire:model.defer="form.treatment"
                        />

                        <x-wire-textarea 
                            label="Notas" 
                            placeholder="Agregue las notas adicionales aquí..."
                            wire:model.defer="form.notes"
                        />
                    </div>
                </x-tab-content>

                <x-tab-content tab="receta">
                    <div class="space-y-4">
                        @forelse ($form['prescriptions'] as $index => $prescription)
                            <div class="bg-gray-50 p-4 rounded-lg border md:flex md:flex-col gap-4 mb-4" wire:key="prescription-{{ $index }}">
                                <div class="flex gap-4">
                                    <div class="flex-1">
                                        <x-wire-input 
                                            label="Medicamento" 
                                            placeholder="Ej: Paracetamol 500mg"
                                            wire:model.defer="form.prescriptions.{{ $index }}.medicine"
                                        />
                                    </div>

                                    <div class="w-32">
                                        <x-wire-input 
                                            label="Dosis" 
                                            placeholder="Ej: 1 cápsula"
                                            wire:model.defer="form.prescriptions.{{ $index }}.dosage"
                                        />
                                    </div>

                                    <div class="flex-1">
                                        <x-wire-input 
                                            label="Frecuencia / Duración" 
                                            placeholder="Ej: Cada 8 horas por 5 días"
                                            wire:model.defer="form.prescriptions.{{ $index }}.frequency"
                                        />
                                    </div>

                                    <div class="flex-shrink-0 pt-7">
                                        <x-wire-mini-button sm red
                                            icon="trash"
                                            wire:click="removePrescription({{ $index }})"
                                            spinner="removePrescription({{ $index }})"
                                        />
                                    </div>
                                </div>
                            </div>
                        @empty

                            <div class="text-center text-gray-500">
                                <p class="text-lg">No hay medicamentos añadidos a la receta.</p>

                        @endforelse

                    </div>

                    <div class="mt-4">
                        <x-wire-button outline secondary
                            wire:click="addPrescription"
                            spinner="addPrescription">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Añadir medicamento
                        </x-wire-button>
                    </div>
                </x-tab-content>    
        </x-tabs>

        <div class="mt-6 flex justify-end">
            <x-wire-button 
                wire:click="save"
                spinner="save">
                <i class="fa-solid fa-save mr-2"></i>
                Guardar consulta
            </x-wire-button>

    </x-wire-card>

    <x-wire-modal-card
        title="Historia médica del paciente"
        name="historyModal"
        width="5xl">
        
        <div class="grid md:grid-cols-4 gap-6">
            <div>
                <p class="font-medium text-gray-500 mb-2">
                    Tipo de sangre:
                </p>
                <p class="font-medium text-gray-800">
                    {{ $patient->bloodType?->name ?? "No registrado" }}
                </p>
            </div>

            <div>
                <p class="font-medium text-gray-500 mb-2">
                    Alergias:
                </p>
                <p class="font-medium text-gray-800">
                    {{ $patient->allergies ?? "No registrado" }}
                </p>
            </div>

            <div>
                <p class="font-medium text-gray-500 mb-2">
                    Enfermedades crónicas:
                </p>
                <p class="font-medium text-gray-800">
                    {{ $patient->chronic_conditions ?? "No registrado" }}
                </p>
            </div>

            <div>
                <p class="font-medium text-gray-500 mb-2">
                    Antecedentes quirúrgicos:
                </p>
                <p class="font-medium text-gray-800">
                    {{ $patient->surgical_history ?? "No registrado" }}
                </p>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end">
                <a href="{{ route('admin.patients.edit', $patient->id) }}"
                    class="font-semibold text-blue-600 hover:text-blue-800" target="_blank">
                    Ver / Editar historia médica
                </a>
            </div>
        </x-slot>


    </x-wire-modal-card>

    <x-wire-modal-card
        title="Consultas anteriores"
        name="previousConsultationsModal"
        width="4xl">

        @forelse ($previousConsultations as $consultation)
            <a href="{{ route('admin.appointments.show', $consultation->appointment_id) }}" target="_blank"
                class="block p-5 rounded-lg shadow-md border-gray-200 hover:border-indigo-400 hover:shadow-indigo-100 transition-all duration-200">

                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold flex items-center text-gray-800">
                            <i class="fa-solid fa-calendar-days text-gray-500"></i>
                            {{ $consultation->appointment->date->format('d/M/Y H:i') }}
                        </p>
                        <p>
                            Atentido por: Dr(a). {{ $consultation->appointment->doctor->user->name }}
                        </p>
                    </div>
                    <div class="">
                        <x-wire-button class="w-full md:w-auto">
                            Ver detalle
                        </x-wire-button>
                    </div>
                </div>
            </a>

            @empty
                <div class="text-center py-10 rounded-xl border border-dashed">
                    <i class="fa-solid fa-inbox text-4xl text-gray-400 mb-4"></i>
                    <p class="text-center text-gray-500">
                        No hay consultas anteriores registradas para este paciente.
                    </p>
                </div>
        @endforelse

        <x-slot name="footer">
            <div class="flex justify-end">
                <x-wire-button outline gray x-on:click="$closeModal('previousConsultationsModal')">
                    Cerrar
                </x-wire-button>
            </div>
        </x-slot>

    </x-wire-modal-card>
</div>
