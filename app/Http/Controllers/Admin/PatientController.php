<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodType;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('read_patient');
        return view('admin.patients.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        Gate::authorize('update_patient');
        $bloodTypes = BloodType::all();
        return view('admin.patients.edit', compact('patient', 'bloodTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        Gate::authorize('update_patient');

        $data = $request->validate([
            'blood_type_id' => 'nullable|exists:blood_types,id',
            'allergies' => 'nullable|string|max:1000',
            'chronic_conditions' => 'nullable|string|max:1000',
            'surgical_history' => 'nullable|string|max:1000',
            'family_history' => 'nullable|string|max:1000',
            'observations' => 'nullable|string|max:2000',

            // 🔹 Nuevos campos
            'current_medications' => 'nullable|string|max:2000',
            'habits' => 'nullable|string|max:2000',
            'blood_pressure' => 'nullable|string|max:50',
            'heart_rate' => 'nullable|string|max:50',
            'respiratory_rate' => 'nullable|string|max:50',
            'temperature' => 'nullable|string|max:50',

            // 🔹 Contactos de emergencia
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relationship' => 'nullable|string|max:100',

            'emergency_contact_name2' => 'nullable|string|max:255',
            'emergency_contact_phone2' => 'nullable|string|max:20',
            'emergency_contact_relationship2' => 'nullable|string|max:100',

            'emergency_contact_name3' => 'nullable|string|max:255',
            'emergency_contact_phone3' => 'nullable|string|max:20',
            'emergency_contact_relationship3' => 'nullable|string|max:100',

            'stature' => 'nullable|string|max:20',
            'weight' => 'nullable|string|max:20',
        ]);

        $patient->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Paciente actualizado',
            'text' => 'El paciente ha sido actualizado exitosamente.'
        ]);

        return redirect()->route('admin.patients.edit', $patient);
    }

    public function dropzone(Request $request, Patient $patient)
    {
        $image = $patient->images()->create([
            'path' => Storage::put('/images', $request->file('file')),
            'size' => $request->file('file')->getSize(),
        ]);

        return response()->json([
            'path' => $image->path,
        ]);
    }
}
