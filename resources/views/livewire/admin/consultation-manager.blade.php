<div>
    <x-wire-card class="mb-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-8">
                    <img src="{{ $appointment->patient->user->profile_photo_url }}" 
                        class="h-20 w-20 rounded-full object-cover object-center" 
                        alt="{{ $appointment->patient->user->name }}">

                    <div>
                        <p class="text-2xl font-bold text-gray-900 mb-1">
                            {{ $appointment->patient->user->name }}
                        </p>
                        <p class="text-smfont-semibold text-gray">
                            DNI: {{ $appointment->patient->user->dni ?? 'N/A' }}
                        </p>
                    </div>
                </div>

                <div class="flex space-x-8">
                    <x-wire-button outline gray>
                        <i class="fa-solid fa-notes-medical md"></i>
                        Ver historial
                    </x-wire-button>

                    <x-wire-button outline gray>
                        <i class="fa-solid fa-clock-rotate-left md"></i>
                        Consultas anteriores
                    </x-wire-button>
                </div>
            </div>
    </x-wire-card>

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
                            <div class="bg-gray-50 p-4 rounded-lg border flex flex-col gap-4 mb-4" wire:key="prescription-{{ $index }}">
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
</div>
