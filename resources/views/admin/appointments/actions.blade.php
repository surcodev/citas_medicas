<div class="d-flex items-center space-x-16">
    <x-wire-button href="{{ route('admin.appointments.edit', $appointment) }}" xs>
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    <x-wire-button href="{{ route('admin.appointments.consultation', $appointment) }}" cyan xs>
        <i class="fa-solid fa-file-lines"></i>
    </x-wire-button>

</div>