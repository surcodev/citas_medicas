<x-admin-layout
    title="Roles"
    :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles',
    ]
    ]"
    >

    <x-slot name="action">
        <x-wire-button href="{{ route('admin.roles.create') }}" blue>
            <i class="fa-solid fa-plus mr-2"></i> Nuevo
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.role-table')

</x-admin-layout>
    