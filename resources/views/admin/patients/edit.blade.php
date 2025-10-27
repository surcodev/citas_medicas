<x-admin-layout
    title="Pacientes"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Pacientes', 'href' => route('admin.patients.index')],
        ['name' => 'Editar']
    ]"
>

    @push('css')
        <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" />
    @endpush

    {{-- FORMULARIO PRINCIPAL --}}
    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
        @csrf
        @method('PUT')

        <x-wire-card class="mb-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-8">
                    <img src="{{ $patient->user->profile_photo_url }}" 
                        class="h-20 w-20 rounded-full object-cover object-center" 
                        alt="{{ $patient->user->name }}">
                    <div>
                        <p class="text-2xl font-bold text-gray-900 mb-1">
                            {{ $patient->user->name }}
                        </p>
                        <p class="text-sm font-semibold text-gray">
                            DNI: {{ $patient->user->dni ?? 'N/A' }}
                        </p>
                    </div>
                </div>
                <div class="flex space-x-8">
                    <x-wire-button outline gray href="{{ route('admin.patients.index') }}">
                        Volver
                    </x-wire-button>
                    <x-wire-button type="submit">
                        <i class="fa-solid fa-check"></i>
                        Guardar cambios
                    </x-wire-button>
                </div>
            </div>
        </x-wire-card>

        {{-- CARD PRINCIPAL CON TABS --}}
        <x-wire-card>
            <x-tabs active="datos-personales">
                <x-slot name="header">
                    <x-tab-link tab="datos-personales">
                        <i class="fa-solid fa-user me-2"></i> Datos Personales
                    </x-tab-link>
                    <x-tab-link tab="antecedentes">
                        <i class="fa-solid fa-file-medical me-2"></i> Anamnesis
                    </x-tab-link>
                    <x-tab-link tab="informacion-general">
                        <i class="fa-solid fa-file-medical me-2"></i> Examen Físico
                    </x-tab-link>
                    <x-tab-link tab="contacto-emergencia">
                        <i class="fa-solid fa-heart me-2"></i> Contactos de Emergencia
                    </x-tab-link>
                </x-slot>

                {{-- TAB 1: Datos Personales --}}
                <x-tab-content tab="datos-personales">
                    <x-wire-alert info title="Edición del paciente" class="mb-4">
                        <p>
                            Para editar esta información, dirígete  
                            <a href="{{ route('admin.users.edit', $patient->user) }}" 
                               class="font-semibold text-blue-600 hover:underline">
                               aquí
                            </a>.
                        </p>
                    </x-wire-alert>

                    <div class="grid lg:grid-cols-2 gap-2">
                        <div><strong>Teléfono:</strong> {{ $patient->user->phone }}</div>
                        <div><strong>Email:</strong> {{ $patient->user->email }}</div>
                        <div><strong>Dirección:</strong> {{ $patient->user->address }}</div>
                        <div><strong>DNI:</strong> {{ $patient->user->dni }}</div>
                    </div>
                </x-tab-content>

                {{-- TAB 2: Antecedentes --}}
                <x-tab-content tab="antecedentes">
                    <label class="block text-sm font-semibold text-gray-500 mb-2">
                        Pruebas médicas
                    </label>

                    {{-- Contenedor visual para Dropzone --}}
                    <div id="dropzone-container" class="mb-6"></div>

                    {{-- Textareas --}}
                    <div class="grid lg:grid-cols-2 gap-4">
                        <x-wire-textarea label="Alergias conocidas" name="allergies" rows="3">{{ old('allergies', $patient->allergies) }}</x-wire-textarea>
                        <x-wire-textarea label="Enfermedades prévias" name="chronic_conditions" rows="3">{{ old('chronic_conditions', $patient->chronic_conditions) }}</x-wire-textarea>
                        <x-wire-textarea label="Antecedentes quirúrgicos" name="surgical_history" rows="3">{{ old('surgical_history', $patient->surgical_history) }}</x-wire-textarea>
                        <x-wire-textarea label="Antecedentes familiares" name="family_history" rows="3">{{ old('family_history', $patient->family_history) }}</x-wire-textarea>
                        <x-wire-textarea label="Medicamentos actuales" name="current_medications" rows="3">{{ old('current_medications', $patient->current_medications) }}</x-wire-textarea>
                        <x-wire-textarea label="Hábitos (tabaquismo, alcohol, alimentación, etc)" name="habits" rows="3">{{ old('habits', $patient->habits) }}</x-wire-textarea>
                    </div>

                    {{-- GRID DE MINIATURAS (archivos existentes) --}}
                        <div id="existing-files" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-6 mt-4">
                            @if ($patient->images && $patient->images->count() > 0)
                                @foreach ($patient->images as $image)
                                    @php
                                        $url = Storage::url($image->path);
                                        $ext = strtolower(pathinfo($image->path, PATHINFO_EXTENSION));
                                        $isPdf = $ext === 'pdf';
                                    @endphp
                                    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="block">
                                        @if ($isPdf)
                                            <div class="w-full h-24 flex items-center justify-center border rounded-lg bg-white shadow-sm p-2 cursor-pointer hover:shadow-md transition-shadow duration-200">
                                                <div class="text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-8 w-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0119 10.5c0 3.866-3.582 7-8 7s-8-3.134-8-7c0-.52.038-1.032.11-1.53L12 14z" />
                                                    </svg>
                                                    <p class="text-xs font-medium truncate w-28">{{ \Illuminate\Support\Str::limit(basename($image->path), 22) }}</p>
                                                    <p class="text-xs text-gray-500">PDF</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="w-full h-24 flex items-center justify-center border rounded-lg bg-white shadow cursor-pointer hover:shadow-md transition-transform transform hover:scale-105 overflow-hidden">
                                                <img src="{{ $url }}" alt="Archivo médico" class="max-h-full max-w-full object-contain">
                                            </div>
                                        @endif
                                    </a>
                                @endforeach
                            @else
                                <p class="text-gray-500 mb-6 text-sm italic">No hay archivos subidos aún.</p>
                            @endif
                        </div>

                </x-tab-content>

                {{-- TAB 3: Información General --}}
                <x-tab-content tab="informacion-general">
                    <div class="grid lg:grid-cols-2 gap-4">
                        <x-wire-input label="Peso (kg)" name="weight" value="{{ old('weight', $patient->weight) }}" />
                        <x-wire-input label="Talla (m)" name="stature" value="{{ old('stature', $patient->stature) }}" />
                        <x-wire-input label="Presión arterial (mmHg)" name="blood_pressure"
                            value="{{ old('blood_pressure', $patient->blood_pressure) }}" />
                        <x-wire-input label="Frecuencia cardíaca (lpm)" name="heart_rate"
                            value="{{ old('heart_rate', $patient->heart_rate) }}" />
                        <x-wire-input label="Frecuencia respiratoria (rpm)" name="respiratory_rate"
                            value="{{ old('respiratory_rate', $patient->respiratory_rate) }}" />
                        <x-wire-input label="Temperatura (°C)" name="temperature"
                            value="{{ old('temperature', $patient->temperature) }}" />
                        <x-wire-native-select label="Tipo de sangre" name="blood_type_id" class="mb-4">
                            <option value="">Seleccione un tipo de sangre</option>
                            @foreach ($bloodTypes as $bloodType)
                                <option value="{{ $bloodType->id }}" @selected($bloodType->id === $patient->blood_type_id)>
                                    {{ $bloodType->name }}
                                </option>
                            @endforeach
                        </x-wire-native-select>

                        <x-wire-textarea label="Observaciones" name="observations" rows="1">
                            {{ old('observations', $patient->observations) }}
                        </x-wire-textarea>
                    </div>
                </x-tab-content>

                {{-- TAB 4: Contacto de emergencia --}}
                <x-tab-content tab="contacto-emergencia">
                    <div class="grid lg:grid-cols-3 gap-4">
                        <x-wire-input label="1. Nombre del contacto" name="emergency_contact_name"
                            value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" />
                        <x-wire-input label="1. Teléfono del contacto" name="emergency_contact_phone"
                            value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}" />
                        <x-wire-input label="1. Relación con el contacto" name="emergency_contact_relationship"
                            value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}" />
                        <x-wire-input label="2. Nombre del contacto" name="emergency_contact_name2"
                        value="{{ old('emergency_contact_name2', $patient->emergency_contact_name2) }}" />
                        <x-wire-input label="2. Teléfono del contacto" name="emergency_contact_phone2"
                            value="{{ old('emergency_contact_phone2', $patient->emergency_contact_phone2) }}" />
                        <x-wire-input label="2. Relación con el contacto" name="emergency_contact_relationship2"
                            value="{{ old('emergency_contact_relationship2', $patient->emergency_contact_relationship2) }}" />
                            <x-wire-input label="3. Nombre del contacto" name="emergency_contact_name3"
                        value="{{ old('emergency_contact_name3', $patient->emergency_contact_name3) }}" />
                        <x-wire-input label="3. Teléfono del contacto" name="emergency_contact_phone3"
                            value="{{ old('emergency_contact_phone3', $patient->emergency_contact_phone3) }}" />
                        <x-wire-input label="3. Relación con el contacto" name="emergency_contact_relationship3"
                            value="{{ old('emergency_contact_relationship3', $patient->emergency_contact_relationship3) }}" />
                    </div>
                </x-tab-content>
            </x-tabs>
        </x-wire-card>
    </form>

    {{-- FORMULARIO DROPZONE SEPARADO PERO EN EL MISMO BLOQUE VISUAL --}}
    <form action="{{ route('admin.patients.dropzone', $patient) }}" 
        method="POST" 
        enctype="multipart/form-data"
        class="dropzone hidden"
        id="my-awesome-dropzone">
        @csrf
    </form>

    @push('js')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dzForm = document.getElementById('my-awesome-dropzone');
    const container = document.getElementById('dropzone-container');

    // Mover el formulario Dropzone al contenedor
    container.appendChild(dzForm);
    dzForm.classList.remove('hidden');

    // Inicializar Dropzone manualmente
    const myDropzone = new Dropzone(dzForm, {
        paramName: "file",
        maxFilesize: 10, // MB
        acceptedFiles: ".jpg,.jpeg,.png,.pdf",
        dictDefaultMessage: "Arrastra archivos o haz clic aquí para subir antecedentes médicos",

        init: function() {
            let images = @json($patient->images);

            images.forEach(image => {
                let mockFile = {
                    id: image.id,
                    name: image.path.split('/').pop(),
                    size: image.size
                };

                this.emit("addedfile", mockFile);

                const ext = image.path.split('.').pop().toLowerCase();
                if(ext !== 'pdf') {
                    this.emit("thumbnail", mockFile, `{{ Storage::url('${image.path}') }}`);
                }

                this.emit("complete", mockFile);
            });
        }
    });
});
</script>
@endpush
</x-admin-layout>