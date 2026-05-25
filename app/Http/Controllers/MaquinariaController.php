<?php

namespace App\Http\Controllers;

use App\Models\Maquinaria;
use Illuminate\Http\Request;

class MaquinariaController extends Controller
{
    public function index()
    {
        $maquinarias = Maquinaria::all();
        return view('maquinaria.index', compact('maquinarias'));
    }

    public function create()
    {
        return view('maquinaria.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'mantenimiento' => 'nullable|string',
        ]);

        Maquinaria::create($validated);

        return redirect()->route('maquinaria.index')
            ->with('success', 'Maquinaria creada exitosamente.');
    }

    public function show(Maquinaria $maquinaria)
    {
        return view('maquinaria.show', compact('maquinaria'));
    }

    public function edit(Maquinaria $maquinaria)
    {
        return view('maquinaria.edit', compact('maquinaria'));
    }

    public function update(Request $request, Maquinaria $maquinaria)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'mantenimiento' => 'nullable|string',
        ]);

        $maquinaria->update($validated);

        return redirect()->route('maquinaria.index')
            ->with('success', 'Maquinaria actualizada exitosamente.');
    }

    public function destroy(Maquinaria $maquinaria)
    {
        // Assuming we can delete maquinaria if no constraints, adjust if needed
        $maquinaria->delete();
        return redirect()->route('maquinaria.index')
            ->with('success', 'Maquinaria eliminada exitosamente.');
    }
}