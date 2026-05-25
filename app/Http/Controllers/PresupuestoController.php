<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use Illuminate\Http\Request;

class PresupuestoController extends Controller
{
    public function index()
    {
        $presupuestos = Presupuesto::all();
        return view('presupuestos.index', compact('presupuestos'));
    }

    public function create()
    {
        return view('presupuestos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'monto_total' => 'required|numeric|min:0',
        ]);

        Presupuesto::create($validated);

        return redirect()->route('presupuestos.index')
            ->with('success', 'Presupuesto creado exitosamente.');
    }

    public function show(Presupuesto $presupuesto)
    {
        return view('presupuestos.show', compact('presupuesto'));
    }

    public function edit(Presupuesto $presupuesto)
    {
        return view('presupuestos.edit', compact('presupuesto'));
    }

    public function update(Request $request, Presupuesto $presupuesto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'monto_total' => 'required|numeric|min:0',
        ]);

        $presupuesto->update($validated);

        return redirect()->route('presupuestos.index')
            ->with('success', 'Presupuesto actualizado exitosamente.');
    }

    public function destroy(Presupuesto $presupuesto)
    {
        // Assuming we can delete presupuesto if no constraints, adjust if needed
        $presupuesto->delete();
        return redirect()->route('presupuestos.index')
            ->with('success', 'Presupuesto eliminado exitosamente.');
    }
}