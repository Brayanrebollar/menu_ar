<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Lista de roles + formulario de creación
    public function index()
    {
        $roles = Role::orderBy('nombre')->get();

        return view('roles.index', compact('roles'));
    }

    // Guardar nuevo rol
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:100|unique:roles,nombre',
            'descripcion' => 'nullable|string|max:255',
        ]);

        Role::create($data);

        return back()->with('success', 'Rol creado correctamente');
    }

    // Mostrar formulario de edición
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    // Actualizar rol
    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:100|unique:roles,nombre,' . $role->id,
            'descripcion' => 'nullable|string|max:255',
        ]);

        $role->update($data);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente');
    }

    // Eliminar rol
    public function destroy(Role $role)
    {
        $role->delete();

        return back()->with('success', 'Rol eliminado correctamente');
    }
}
