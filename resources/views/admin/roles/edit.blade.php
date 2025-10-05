<x-admin-layout
    title="Dashboard"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Roles',
            'href' => route('admin.roles.index'),
        ],
        [
            'name' => 'Editar',
        ]
    ]">

    <x-wire-card>

        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')

            <x-wire-input
                name="name"
                label="Nombre"
                placeholder="Nombre del rol"
                value="{{ old('name', $role->name) }}"
            />

            <div class="flex justify-end mt-4">
                <x-wire-button type="submit" color="blue">
                    Actualizar
                </x-wire-button>
            </div>
        </form>
    </x-wire-card>    

</x-admin-layout>
    