<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\Rol;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function index()
    {
        $personal = Personal::with('rol')->get();
        return view('personal.index', compact('personal'));
    }

    public function create()
    {
        $roles = Rol::all();
        return view('personal.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'rol_id' => 'nullable|exists:rols,id',
            'habilidades' => 'nullable|string',
            'contrato' => 'nullable|date',
        ]);

        Personal::create($validated);

        return redirect()->route('personal.index')
            ->with('success', 'Personal creado exitosamente.');
    }

    public function show(Personal $personal)
    {
        $personal->load('rol');
        return view('personal.show', compact('personal'));
    }

    public function edit(Personal $personal)
    {
        $roles = Rol::all();
        return view('personal.edit', compact('personal', 'roles'));
    }

    public function update(Request $request, Personal $personal)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'rol_id' => 'nullable|exists:rols,id',
            'habilidades' => 'nullable|string',
            'contrato' => 'nullable|date',
        ]);

        $personal->update($validated);

        return redirect()->route('personal.index')
            ->with('success', 'Personal actualizado exitosamente.');
    }

    public function destroy(Personal $personal)
    {
        // Assuming we can delete personal if no constraints, adjust if needed
        $personal->delete();
        return redirect()->route('personal.index')
            ->with('success', 'Personal eliminado exitosamente.');
    }
}