<x-admin-layout
    title="Citas"
    :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Citas',
    ]
    ]"
    >

    <x-slot name="action">
        <x-wire-button href="{{ route('admin.appointments.create') }}" blue>
            <i class="fa-solid fa-plus mr-2"></i> Nuevo
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.appointment-table')

</x-admin-layout>
    