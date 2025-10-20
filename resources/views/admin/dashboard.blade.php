<x-admin-layout>

    @role(['Administrador', 'Recepcionista'])
        @include('admin.dashboard.admin')
    @endrole

    @role(['Doctor'])
        @include('admin.dashboard.doctor')
    @endrole

</x-admin-layout>
    