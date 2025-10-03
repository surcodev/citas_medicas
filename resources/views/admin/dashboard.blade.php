<x-admin-layout 
title="Dashboard"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Pruebas',        
    ]
    ]">

</div>
    
    {{-- <x-slot name="action">
        <x-button href="{{ route('admin.users.index') }}">
            <i class="fa-solid fa-users"></i> Usuarios
        </x-button>
    </x-slot> --}}

    Hola desde el dashboard
</x-admin-layout>
    