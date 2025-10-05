<x-admin-layout
    title="Usuarios"
    :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
        'href' => route('admin.users.index'),
    ],
    [
        'name' => 'Nuevo',
    ]]"
    >

    <x-wire-card>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-4">
                    <x-wire-input
                        name="name"
                        label="Nombre"
                        required
                        :value="old('name')"
                        placeholder="Ingrese el nombre del usuario"
                    />
                    <x-wire-input
                        name="email"
                        label="Correo electrónico"
                        type="email"
                        required
                        :value="old('email')"
                        placeholder="Ingrese el correo electrónico del usuario"
                    />
                    <x-wire-input
                        name="password"
                        label="Contraseña"
                        type="password"
                        required
                        placeholder="Ingrese la contraseña del usuario"
                    />
                    <x-wire-input
                        name="password_confirmation"
                        label="Confirmar Contraseña"
                        type="password"
                        required
                        placeholder="Confirme la contraseña del usuario"
                    />

                    {{-- DNI --}}
                    <x-wire-input
                        name="dni"
                        label="DNI"
                        :value="old('dni')"
                        placeholder="Ingrese el DNI del usuario"
                    />
                    {{-- Phone --}}
                    <x-wire-input
                        name="phone"
                        label="Teléfono"
                        :value="old('phone')"
                        placeholder="Ingrese el teléfono del usuario"
                    />
                </div>

                {{-- Dirección --}}
                <x-wire-input
                    name="address"
                    label="Dirección"
                    :value="old('address')"
                    placeholder="Ingrese la dirección del usuario"
                />

                {{-- Roles --}}
                <x-wire-native-select name="role_id" label="Rol">

                    <option value="" disabled selected>Seleccione un rol</option>

                    @foreach ($roles as $role)
                        <option
                            value="{{ $role->id }}"
                            @selected(old('role') == $role->id)
                        >
                            {{ $role->name }}
                    @endforeach
                </x-wire-native-select>
            </div>

            <div class="flex justify-end mt-4">
                <x-wire-button type="submit" >
                    Guardar
                </x-wire-button>
            </div>
        </form>
    </x-wire-card>

</x-admin-layout>
    