<x-admin-layout
    title="Horarios"
    :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Horarios',
    ]
    ]"
    >
    @livewire('admin.schedule-manager', [
        'doctor' => $doctor
    ])
</x-admin-layout>
    