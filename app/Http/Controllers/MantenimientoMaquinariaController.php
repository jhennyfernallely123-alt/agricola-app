<?php

namespace App\Http\Controllers;

use App\Models\MantenimientoMaquinaria;
use App\Models\Maquinaria;
use Illuminate\Http\Request;

class MantenimientoMaquinariaController extends Controller
{
    public function index()
    {
        $mantenimientos = MantenimientoMaquinaria::with('maquinaria')->get();
        return view('mantenimiento_maquinaria.index', compact('mantenimientos'));
    }

    public function create()
    {
        $maquinarias = Maquinaria::all();
        return view('mantenimiento_maquinaria.create', compact('maquinarias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'maquinaria_id' => 'required|exists:maquinarias,id',
            'fecha' => 'required|date',
            'tipo' => 'required|string|max:255',
            'costo' => 'nullable|numeric|min:0',
        ]);

        MantenimientoMaquinaria::create($validated);

        return redirect()->route('mantenimiento.index')
            ->with('success', 'Mantenimiento registrado exitosamente.');
    }

    public function show(MantenimientoMaquinaria $mantenimiento)
    {
        $mantenimiento->load('maquinaria');
        return view('mantenimiento_maquinaria.show', compact('mantenimiento'));
    }

    public function edit(MantenimientoMaquinaria $mantenimiento)
    {
        $maquinarias = Maquinaria::all();
        return view('mantenimiento_maquinaria.edit', compact('mantenimiento', 'maquinarias'));
    }

    public function update(Request $request, MantenimientoMaquinaria $mantenimiento)
    {
        $validated = $request->validate([
            'maquinaria_id' => 'required|exists:maquinarias,id',
            'fecha' => 'required|date',
            'tipo' => 'required|string|max:255',
            'costo' => 'nullable|numeric|min:0',
        ]);

        $mantenimiento->update($validated);

        return redirect()->route('mantenimiento.index')
            ->with('success', 'Mantenimiento actualizado exitosamente.');
    }

    public function destroy(MantenimientoMaquinaria $mantenimiento)
    {
        $mantenimiento->delete();
        return redirect()->route('mantenimiento.index')
            ->with('success', 'Mantenimiento eliminado exitosamente.');
    }
}