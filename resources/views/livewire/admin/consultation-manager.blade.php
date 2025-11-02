@push('css')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" />
@endpush

<div>

<div class="">
    <div class="md:flex md:justify-between items-center mb-4">
        <div>
            <p class="text-2xl font-bold text-gray-900 mb-1">
                {{ $appointment->patient->user->name }}
            </p>
            <p class="text-sm font-semibold text-gray">
                DNI: {{ $appointment->patient->user->dni ?? 'N/A' }}
            </p>
            <p class="text-sm font-semibold text-gray">
                MOTIVO DE LA CITA: {{ $appointment->reason ?? 'N/A' }}
            </p>
        </div>

        <div class="flex space-x-8 ">
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
                    <i class="fa-solid fa-file-medical me-2"></i> Consulta
                </x-tab-link>
                <x-tab-link tab="receta">
                    <i class="fa-solid fa-prescription-bottle-medical me-2"></i> Receta
                </x-tab-link>
            </x-slot>

            {{-- TAB CONSULTA --}}
<x-tab-content tab="consulta">
    <div class="space-y-4">
        {{-- GRID DE 3 COLUMNAS PARA TEXTAREAS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <x-wire-textarea 
                    label="Diagnóstico" 
                    placeholder="Describa diagnóstico del paciente aquí..."
                    wire:model.defer="form.diagnosis"
                    rows="3"
                />
            </div>

            <div>
                <x-wire-textarea 
                    label="Tratamiento" 
                    placeholder="Describa el tratamiento aquí..."
                    wire:model.defer="form.treatment"
                    rows="3"
                />
            </div>

            <div>
                <x-wire-textarea 
                    label="Notas" 
                    placeholder="Agregue las notas adicionales aquí..."
                    wire:model.defer="form.notes"
                    rows="3"
                />
            </div>
        </div>

        {{-- Dropzone --}}
        <div class="mt-4">
            <label class="block text-sm font-semibold text-gray-500 mb-2">
                Pruebas médicas (Adjuntar imágenes o documentos PNG, JPEG, PDF)
            </label>

            @if ($appointment->status->isEditable())
                <div id="dropzone-container" class="border border-dashed rounded-lg p-4 bg-gray-50 text-center text-gray-400 hover:bg-gray-100 cursor-pointer transition">
                    Arrastra archivos o haz clic aquí para subir pruebas médicas
                </div>
            @endif

            {{-- GRID DE MINIATURAS (archivos existentes) --}}
            <div id="existing-files" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
                @if ($consultation->images && $consultation->images->count() > 0)
                    @foreach ($consultation->images as $image)
                        @php
                            $url = Storage::url($image->path);
                            $ext = strtolower(pathinfo($image->path, PATHINFO_EXTENSION));
                            $isPdf = $ext === 'pdf';
                        @endphp

                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="block">
                            @if ($isPdf)
                                <div class="w-full h-24 flex flex-col items-center justify-center border rounded-lg bg-white shadow-sm p-2 hover:shadow-md transition">
                                    <i class="fa-regular fa-file-pdf text-3xl mb-1 text-red-600"></i>
                                    <p class="text-xs text-gray-600 truncate w-28">{{ basename($image->path) }}</p>
                                </div>
                            @else
                                <div class="w-full h-24 flex items-center justify-center border rounded-lg bg-white overflow-hidden hover:shadow-md transition">
                                    <img src="{{ $url }}" class="max-h-full max-w-full object-contain" alt="Adjunto">
                                </div>
                            @endif
                        </a>
                    @endforeach
                @else
                    <p class="text-gray-500 mb-6 text-sm italic">No hay archivos subidos aún.</p>
                @endif
            </div>
        </div>
    </div>
</x-tab-content>


            {{-- TAB RECETA --}}
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
                        </div>
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
                spinner="save"
                :disabled="!$appointment->status->isEditable()">
                <i class="fa-solid fa-save mr-2"></i>
                Guardar consulta
            </x-wire-button>
        </div>
    </x-wire-card>

    {{-- MODALES --}}
    <x-wire-modal-card
        title="Historia médica del paciente"
        name="historyModal"
        width="5xl">
        
        <div class="grid md:grid-cols-4 gap-6">
            <div>
                <p class="font-medium text-gray-500 mb-2">
                    Peso:
                </p>
                <p class="font-medium text-gray-800">
                    {{ $patient->weight ? $patient->weight . ' kg' : 'No registrado' }}
                </p>
            </div>

            <div>
                <p class="font-medium text-gray-500 mb-2">
                    Talla:
                </p>
                <p class="font-medium text-gray-800">
                    {{ $patient->stature ? $patient->stature . ' m' : 'No registrado' }}
                </p>
            </div>

            <div>
                <p class="font-medium text-gray-500 mb-2">
                    Presión arterial :
                </p>
                <p class="font-medium text-gray-800">
                    {{ $patient->blood_pressure ? $patient->blood_pressure . ' mmHg' : 'No registrado' }}
                </p>
            </div>

            <div>
                <p class="font-medium text-gray-500 mb-2">
                    Frecuencia cardíaca:
                </p>
                <p class="font-medium text-gray-800">
                    {{ $patient->respiratory_rate ? $patient->respiratory_rate . ' lpm' : 'No registrado' }}
                </p>
            </div>
        </div>
        <div class="grid md:grid-cols-4 gap-6 mt-6">
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

    @forelse ($previousConsultations as $i => $consultation)

        <div x-data="{ open: false }" class="mb-3 border rounded-lg">
            {{-- HEADER DEL ACORDEÓN --}}
            <button x-on:click="open = !open"
                class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 rounded-lg">
                <div>
                    <p class="font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-days text-gray-500"></i>
                        {{ $consultation->appointment->date->format('d/M/Y') }}
                        ({{ $consultation->appointment->start_time->format('H:i') }} -
                        {{ $consultation->appointment->end_time->format('H:i') }})
                    </p>
                    <p class="text-sm text-gray-600">
                        Atendido por: Dra. {{ $consultation->appointment->doctor->user->name }} 
                        el {{ $consultation->appointment->date->format('d/m/Y') }} 
                        a las {{ $consultation->created_at->format('H:i') }}

                    </p>
                </div>
                <i class="fa-solid" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </button>

            {{-- CUERPO DEL ACORDEÓN --}}
            <div x-show="open" x-collapse class="p-5 space-y-3 text-sm text-gray-700">

                <p><strong>Diagnóstico:</strong> {{ $consultation->diagnosis ?? '' }}</p>
                <p><strong>Tratamiento:</strong> {{ $consultation->treatment ?? '' }}</p>
                <p><strong>Notas:</strong> {{ $consultation->notes ?? '' }}</p>

                {{-- IMÁGENES / PDF ADJUNTOS --}}
    @if($consultation->images && $consultation->images->count())
<div class="mt-3">
    <p class="font-semibold mb-2 text-gray-800">Archivos adjuntos:</p>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($consultation->images as $image)
            @php
                $url = Storage::url($image->path);
                $ext = strtolower(pathinfo($image->path, PATHINFO_EXTENSION));
                $isPdf = $ext === 'pdf';
            @endphp

            <a href="{{ $url }}" target="_blank" class="block">
                @if($isPdf)
                    <div class="w-full h-24 flex flex-col items-center justify-center border rounded-lg bg-white shadow-sm p-2 hover:shadow-md transition">
                        <i class="fa-regular fa-file-pdf text-3xl mb-1 text-red-600"></i>
                        <p class="text-xs text-gray-600 truncate w-28">{{ basename($image->path) }}</p>
                    </div>
                @else
                    <div class="w-full h-24 flex items-center justify-center border rounded-lg bg-white overflow-hidden hover:shadow-md transition">
                        <img src="{{ $url }}" class="max-h-full max-w-full object-contain" alt="Adjunto">
                    </div>
                @endif
            </a>
        @endforeach
    </div>
</div>
@endif



                @if($consultation->prescriptions && is_array($consultation->prescriptions))
    {{-- RECETA EN TABLA --}}
@if(!empty($consultation->prescriptions) && is_array($consultation->prescriptions))
    <div>
        <p class="font-semibold mb-2 text-gray-800">Receta:</p>
        <table class="w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-2 border">Medicamento</th>
                    <th class="px-3 py-2 border">Dosis</th>
                    <th class="px-3 py-2 border">Frecuencia</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultation->prescriptions as $item)
                    <tr>
                        <td class="px-3 py-2 border">{{ $item['medicine'] ?? '' }}</td>
                        <td class="px-3 py-2 border">{{ $item['dosage'] ?? '' }}</td>
                        <td class="px-3 py-2 border">{{ $item['frequency'] ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

@else
    <p><strong>Receta:</strong> —</p>
@endif

                <div class="text-right hidden">
                    <x-wire-button
                        href="{{ route('admin.appointments.consultation', $consultation->appointment_id) }}"
                        target="_blank">
                        Ver detalle completo
                    </x-wire-button>
                </div>
            </div>
        </div>

    @empty
        <div class="text-center py-10 rounded-xl border border-dashed">
            <i class="fa-solid fa-inbox text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-500">No hay consultas anteriores registradas para este paciente.</p>
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

{{-- FORMULARIO DROPZONE --}}
<form action="{{ route('admin.consultation.dropzone', $appointment->consultation) }}" 
      method="POST" 
      enctype="multipart/form-data"
      class="dropzone hidden"
      id="my-awesome-dropzone">
    @csrf
</form>



</div>

@push('js')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dzForm = document.getElementById('my-awesome-dropzone');
    const container = document.getElementById('dropzone-container');

    container.appendChild(dzForm);
    dzForm.classList.remove('hidden');

    const myDropzone = new Dropzone(dzForm, {
        paramName: "file",
        maxFilesize: 10, // MB
        acceptedFiles: ".jpg,.jpeg,.png,.pdf",
        dictDefaultMessage: "Arrastra archivos o haz clic aquí para subir pruebas médicas",

        init: function() {
            // Archivos existentes
            let images = @json($appointment->consultation->images);

            images.forEach(image => {
                let mockFile = { 
                    name: image.path.split('/').pop(),
                    size: image.size,
                    url: `{{ Storage::url('${image.path}') }}`
                };

                this.emit("addedfile", mockFile);

                const ext = mockFile.name.split('.').pop().toLowerCase();
                if(ext !== 'pdf') {
                    this.emit("thumbnail", mockFile, mockFile.url);
                }

                this.emit("complete", mockFile);
            });
        }
    });
});
</script>

@endpush
