<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodType;
use App\Models\Patient;
use Faker\Core\Blood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
            'allergies' => 'nullable|string|max:255',
            'chronic_conditions' => 'nullable|string|max:255',
            'surgical_history' => 'nullable|string|max:255',
            'family_history' => 'nullable|string|max:255',
            'observations' => 'nullable|string|max:1000',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'stature' => 'nullable|string|max:20',
            'weight' => 'nullable|string|max:20',
            'emergency_contact_relationship' => 'nullable|string|max:100'
        ]);

        session()->flash('swal',[
            'icon'=>'success',
            'title'=>'Paciente actualizado',
            'text'=>'El paciente ha sido actualizado exitosamente.'
        ]);

        $patient->update($data);

        return redirect()->route('admin.patients.edit', $patient);
    }
}
