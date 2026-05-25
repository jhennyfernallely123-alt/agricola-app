<?php

namespace App\Http\Controllers;

use App\Models\LaborAgricola;
use App\Models\Cultivo;
use App\Models\Personal;
use Illuminate\Http\Request;

class LaborAgricolaController extends Controller
{
    public function index()
    {
        $labores = LaborAgricola::with(['cultivo', 'empleado'])->get();
        return view('labores_agricolas.index', compact('labores'));
    }

    public function create()
    {
        $cultivos = Cultivo::all();
        $empleados = Personal::all();
        return view('labores_agricolas.create', compact('cultivos', 'empleados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cultivo_id' => 'required|exists:cultivos,id',
            'empleado_id' => 'required|exists:empleados,id',
            'tipo' => 'required|string|max:255',
            'fecha' => 'required|date',
            'costo' => 'nullable|numeric|min:0',
        ]);

        LaborAgricola::create($validated);

        return redirect()->route('labores-agricolas.index')
            ->with('success', 'Labor agrícola creada exitosamente.');
    }

    public function show(LaborAgricola $labor)
    {
        $labor->load(['cultivo', 'empleado']);
        return view('labores_agricolas.show', compact('labor'));
    }

    public function edit(LaborAgricola $labor)
    {
        $cultivos = Cultivo::all();
        $empleados = Personal::all();
        return view('labores_agricolas.edit', compact('labor', 'cultivos', 'empleados'));
    }

    public function update(Request $request, LaborAgricola $labor)
    {
        $validated = $request->validate([
            'cultivo_id' => 'required|exists:cultivos,id',
            'empleado_id' => 'required|exists:empleados,id',
            'tipo' => 'required|string|max:255',
            'fecha' => 'required|date',
            'costo' => 'nullable|numeric|min:0',
        ]);

        $labor->update($validated);

        return redirect()->route('labores-agricolas.index')
            ->with('success', 'Labor agrícola actualizada exitosamente.');
    }

    public function destroy(LaborAgricola $labor)
    {
        $labor->delete();
        return redirect()->route('labores-agricolas.index')
            ->with('success', 'Labor agrícola eliminada exitosamente.');
    }
}