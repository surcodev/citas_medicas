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
        'name' => 'Editar',
    ]]"
    >

    <x-wire-card>

        <form action="{{ route('admin.users.update',$user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-4">
                    <x-wire-input
                        name="name"
                        label="Nombre"
                        required
                        :value="old('name', $user->name)"
                        placeholder="Ingrese el nombre del usuario"
                    />
                    <x-wire-input
                        name="email"
                        label="Correo electrónico"
                        type="email"
                        required
                        :value="old('email', $user->email)"
                        placeholder="Ingrese el correo electrónico del usuario"
                    />
                    <x-wire-input
                        name="password"
                        label="Contraseña"
                        type="password"
                        placeholder="Ingrese la contraseña del usuario"
                        class="hidden"
                        value="asd"
                    />
                    <x-wire-input
                        name="password_confirmation"
                        label="Confirmar Contraseña"
                        type="password"
                        placeholder="Confirme la contraseña del Paciente"
                        class="hidden"
                        value="asd"
                    />

                    {{-- DNI --}}
                    <x-wire-input
                        name="dni"
                        label="DNI"
                        :value="old('dni', $user->dni)"
                        placeholder="Ingrese el DNI del Paciente"
                    />
                    {{-- Phone --}}
                    <x-wire-input
                        name="phone"
                        label="Teléfono"
                        :value="old('phone', $user->phone)"
                        placeholder="Ingrese el teléfono del paciente"
                    />
                </div>

                {{-- Dirección --}}
                <x-wire-input
                    name="address"
                    label="Dirección"
                    :value="old('address', $user->address)"
                    placeholder="Ingrese la dirección del paciente"
                />

                {{-- Roles --}}
                <x-wire-native-select name="role_id" label="Rol" class="hidden">

                    <option value="" disabled selected>Seleccione un rol</option>

                    @foreach ($roles as $role)
                        <option
                            value="{{ $role->id }}"
                            @selected(old('role', $user->roles->first()->id) == $role->id)
                        >
                            {{ $role->name }}
                    @endforeach
                </x-wire-native-select>
            </div>

            <div class="flex justify-end mt-4">
                <x-wire-button type="submit" >
                    Actualizar
                </x-wire-button>
            </div>
        </form>
    </x-wire-card>

</x-admin-layout>
    