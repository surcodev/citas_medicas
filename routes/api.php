<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Appointment;
use App\Models\User;

Route::get('/patients', function (Request $request) {
    return User::query()
            ->select('id', 'name', 'email')
            ->when(
                $request->search,
                fn ($query) => $query
                    ->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                // fn ($query) => $query->whereIn('id', $request->input('selected', [])),
                fn ($query) => $query->whereHas('patient', function ($query) use ($request) {
                    $query->whereIn('id', $request->input('selected', []));
                }),
                fn ($query) => $query->limit(10)
            )
            ->wherehas('patient')
            ->with('patient')
            ->orderBy('name')
            ->get()
            ->map(function (User $user) {
                return [
                    'id' => $user->patient->id,
                    'name' => $user->name,
                ];
            });
})->name('api.patients.index');

Route::get('/appointments', function (Request $request) {
    $appointments = Appointment::with(['patient.user', 'doctor.user'])
        ->whereBetween('date', [$request->start, $request->end])
        ->get();

    return $appointments->map(function (Appointment $appointment) {

        return [
            'id' => $appointment->id,
            'title' => $appointment->patient?->user?->name ?? 'Sin paciente',
            'start' => $appointment->start,
            'end' => $appointment->end,
            'color' => $appointment->status?->colorHex() ?? '#000000',
            'extendedProps' => [
                'dateTime' => $appointment->start,
                'patient' => $appointment->patient?->user?->name ?? 'Sin paciente',
                'doctor' => $appointment->doctor?->user?->name ?? 'Sin doctor',
                'status' => $appointment->status?->label() ?? 'Sin estado',
                'color' => $appointment->status?->color() ?? '#000000',
                'url' => route('admin.appointments.consultation', $appointment->id, absolute: true),
            ],
        ];
    });
})->name('api.appointments.index');