<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('read_appointment');
        return view('admin.appointments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create_appointment');
        return view('admin.appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create_appointment');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        Gate::authorize('read_appointment');
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        Gate::authorize('update_appointment');
        return view('admin.appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        Gate::authorize('update_appointment');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        Gate::authorize('delete_appointment');
    }

    public function consultation(Appointment $appointment)
    {
        Gate::authorize('update_appointment');
        return view('admin.appointments.consultation', compact('appointment'));
    }

    public function dropzone(Request $request, Appointment $appointment)
    {
        $image = $appointment->images()->create([
            'path' => Storage::put('/images', $request->file('file')),
            'size' => $request->file('file')->getSize(),
        ]);

        return response()->json([
            'path' => $image->path,
        ]);
    }
}
