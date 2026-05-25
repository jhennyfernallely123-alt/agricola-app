<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::withCount('empleados')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Rol::create($validated);

        return redirect()->route('roles.index')
            ->with('success', 'Rol creado exitosamente.');
    }

    public function show(Rol $rol)
    {
        $rol->load('empleados');
        return view('roles.show', compact('rol'));
    }

    public function edit(Rol $rol)
    {
        return view('roles.edit', compact('rol'));
    }

    public function update(Request $request, Rol $rol)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $rol->update($validated);

        return redirect()->route('roles.index')
            ->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy(Rol $rol)
    {
        // Check if rol has associated personal
        if ($rol->empleados()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el rol porque tiene personal asociado.');
        }

        $rol->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Rol eliminado exitosamente.');
    }
}