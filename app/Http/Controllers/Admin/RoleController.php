<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        Role::create(['name' => $request->name]);

        session()->flash('swal', [
            'title' => 'Rol creado exitosamente',
            'text' => 'El rol ha sido creado exitosamente',
            'icon' => 'success',
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        if ($role->id <= 4) {
            session()->flash('swal', [
                'title' => 'Acción no permitida',
                'text' => 'No puedes editar este rol',
                'icon' => 'error',
            ]);
            return redirect()->route('admin.roles.index');
        }

        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $request->name]);

        session()->flash('swal', [
            'title' => 'Rol actualizado exitosamente',
            'text' => 'El rol ha sido actualizado exitosamente',
            'icon' => 'success',
        ]);

        return redirect()->route('admin.roles.edit', $role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {

        if ($role->id <= 4) {
            session()->flash('swal', [
                'title' => 'Acción no permitida',
                'text' => 'No puedes eliminar este rol',
                'icon' => 'error',
            ]);
            return redirect()->route('admin.roles.index');
        }

        $role->delete();

        session()->flash('swal', [
            'title' => 'Rol eliminado exitosamente',
            'text' => 'El rol ha sido eliminado exitosamente',
            'icon' => 'success',
        ]);

        return redirect()->route('admin.roles.index');
    }
}
