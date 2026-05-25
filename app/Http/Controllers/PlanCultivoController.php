<?php

namespace App\Http\Controllers;

use App\Models\PlanCultivo;
use App\Models\Cultivo;
use Illuminate\Http\Request;

class PlanCultivoController extends Controller
{
    public function index()
    {
        $planes = PlanCultivo::with(['cultivo'])->get();
        return view('planes_cultivo.index', compact('planes'));
    }

    public function create()
    {
        $cultivos = Cultivo::all();
        return view('planes_cultivo.create', compact('cultivos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cultivo_id' => 'required|exists:cultivos,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin_prevista' => 'required|date|after_or_equal:fecha_inicio',
            'objetivo_produccion' => 'nullable|numeric|min:0',
        ]);

        PlanCultivo::create($validated);

        return redirect()->route('planes-cultivo.index')
            ->with('success', 'Plan de cultivo creado exitosamente.');
    }

    public function show(PlanCultivo $plan)
    {
        $plan->load('cultivo');
        return view('planes_cultivo.show', compact('plan'));
    }

    public function edit(PlanCultivo $plan)
    {
        $cultivos = Cultivo::all();
        return view('planes_cultivo.edit', compact('plan', 'cultivos'));
    }

    public function update(Request $request, PlanCultivo $plan)
    {
        $validated = $request->validate([
            'cultivo_id' => 'required|exists:cultivos,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin_prevista' => 'required|date|after_or_equal:fecha_inicio',
            'objetivo_produccion' => 'nullable|numeric|min:0',
        ]);

        $plan->update($validated);

        return redirect()->route('planes-cultivo.index')
            ->with('success', 'Plan de cultivo actualizado exitosamente.');
    }

    public function destroy(PlanCultivo $plan)
    {
        $plan->delete();
        return redirect()->route('planes-cultivo.index')
            ->with('success', 'Plan de cultivo eliminado exitosamente.');
    }
}