<x-admin-layout
    title="Pacientes"
    :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Pacientes',
    ]
    ]"
    >

    <x-slot name="action">
        <x-wire-button href="{{ route('admin.users.create') }}">
            <i class="fa-solid fa-plus mr-2"></i> Nuevo
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.patient-table')

</x-admin-layout>
    