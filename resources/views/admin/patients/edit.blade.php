<x-admin-layout
    title="Pacientes"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Pacientes',
            'href' => route('admin.patients.index'),
        ],
        [
            'name' => 'Editar',
        ]
    ]"
>

    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Encabezado --}}
        <x-wire-card class="mb-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-8">
                    <img src="{{ $patient->user->profile_photo_url }}" 
                        class="h-20 w-20 rounded-full object-cover object-center" 
                        alt="{{ $patient->user->name }}">

                    <div>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $patient->user->name }}
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

        {{-- TABS --}}
        <x-wire-card>
            <div x-data="{ tab: 'datos-personales' }">
                {{-- Cabecera de Tabs --}}
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                        <li class="me-2">
                            <a href="#"
                                x-on:click.prevent="tab = 'datos-personales'"
                                :class="{
                                    'inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500': tab === 'datos-personales',
                                    'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300': tab !== 'datos-personales'
                                }"
                            >
                                <i class="fa-solid fa-user me-2"></i>
                                Datos Personales
                            </a>
                        </li>

                        <li class="me-2">
                            <a href="#"
                                x-on:click.prevent="tab = 'antescedentes'"
                                :class="{
                                    'inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500': tab === 'antescedentes',
                                    'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300': tab !== 'antescedentes'
                                }"
                            >
                                <i class="fa-solid fa-file-medical me-2"></i>
                                Antecedentes
                            </a>
                        </li>

                        <li class="me-2">
                            <a href="#"
                                x-on:click.prevent="tab = 'informacion-general'"
                                :class="{
                                    'inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500': tab === 'informacion-general',
                                    'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300': tab !== 'informacion-general'
                                }"
                            >
                                <i class="fa-solid fa-info me-2"></i>
                                Información General
                            </a>
                        </li>

                        <li class="me-2">
                            <a href="#"
                                x-on:click.prevent="tab = 'contacto-emergencia'"
                                :class="{
                                    'inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500': tab === 'contacto-emergencia',
                                    'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300': tab !== 'contacto-emergencia'
                                }"
                            >
                                <i class="fa-solid fa-heart me-2"></i>
                                Contacto de Emergencia
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Contenido de Tabs --}}
                <div class="px-4 mt-4">
                    {{-- DATOS PERSONALES --}}
                    <div x-show="tab === 'datos-personales'" x-cloak>
                        <x-wire-alert info title="Edición de usuario" class="mb-4">
                            <p>
                                Para editar esta información, dirígete al 
                                <a href="{{ route('admin.users.edit', $patient->user) }}" 
                                class="font-semibold text-blue-600 hover:underline" 
                                target="_blank">
                                perfil del usuario
                                </a> asociado a este paciente.
                            </p>
                        </x-wire-alert>

                        <div class="grid lg:grid-cols-2 gap-2">
                            <div class="flex items-center">
                                <span class="text-gray-900 font-bold text-sm mr-2">Teléfono:</span>
                                <span class="text-gray-800 text-sm">{{ $patient->user->phone }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-900 font-bold text-sm mr-2">Email:</span>
                                <span class="text-gray-800 text-sm">{{ $patient->user->email }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-900 font-bold text-sm mr-2">Dirección:</span>
                                <span class="text-gray-800 text-sm">{{ $patient->user->address }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-900 font-bold text-sm mr-2">DNI:</span>
                                <span class="text-gray-800 text-sm">{{ $patient->user->dni }}</span>
                            </div>
                        </div>
                    </div>


                    {{-- ANTECEDENTES --}}
                    <div x-show="tab === 'antescedentes'" x-cloak>
                        <div class="grid lg:grid-cols-2 gap-4">
                            <div>
                                <x-wire-textarea
                                label="Alergias conocidas"
                                name="allergies"
                                >
                                {{ old('allergies', $patient->allergies) }}
                                </x-wire-textarea>
                            </div>
                            <div>
                                <x-wire-textarea
                                label="Enfermedades crónicas"
                                name="chronic_conditions"
                                >
                                {{ old('chronic_conditions', $patient->chronic_conditions) }}
                                </x-wire-textarea>
                            </div>
                            <div>
                                <x-wire-textarea
                                label="Antecedentes quirúrgicos"
                                name="surgical_history"
                                >
                                {{ old('surgical_history', $patient->surgical_history) }}
                                </x-wire-textarea>
                            </div>
                            <div>
                                <x-wire-textarea
                                label="Antecedentes familiares"
                                name="family_history"
                                >
                                {{ old('family_history', $patient->family_history) }}
                                </x-wire-textarea>
                            </div>
                        </div>
                        
                    </div>

                    {{-- INFORMACIÓN GENERAL --}}
                    <div x-show="tab === 'informacion-general'" x-cloak>
                        <x-wire-native-select
                            label="Tipo de sangre"
                            name="blood_type_id"
                            class="mb-4"
                        >
                        <option value="">Seleccione un tipo de sangre</option>
                        @foreach ($bloodTypes as $bloodType)
                            <option value="{{ $bloodType->id }}" @selected($bloodType->id === $patient->blood_type_id)>
                                {{ $bloodType->name }}
                            </option>
                                
                        @endforeach
                        </x-wire-native-select>

                        <x-wire-textarea
                            label="Observaciones"
                            name="observations"
                        >
                            {{ old('observations', $patient->observations) }}
                        </x-wire-textarea>

                    </div>

                    {{-- CONTACTO DE EMERGENCIA --}}
                    <div x-show="tab === 'contacto-emergencia'" x-cloak>
                        <div class="space-y-4">
                            <x-wire-input
                                label="Nombre del contacto"
                                name="emergency_contact_name"
                                value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"
                            />
                            <x-wire-input
                                label="Teléfono del contacto"
                                name="emergency_contact_phone"
                                value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}"
                            />
                            <x-wire-input
                                label="Relación con el contacto"
                                name="emergency_contact_relationship"
                                value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}"
                            />
                        </div>
                    </div>
                </div>

            </div>
        </x-wire-card>
    </form>
</x-admin-layout>
