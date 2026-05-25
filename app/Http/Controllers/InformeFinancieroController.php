<?php

namespace App\Http\Controllers;

use App\Models\InformeFinanciero;
use Illuminate\Http\Request;

class InformeFinancieroController extends Controller
{
    public function index()
    {
        $informes = InformeFinanciero::all();
        return view('informes_financieros.index', compact('informes'));
    }

    public function create()
    {
        return view('informes_financieros.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'ingresos_totales' => 'required|numeric|min:0',
            'gastos_totales' => 'required|numeric|min:0',
            'rentabilidad' => 'nullable|numeric',
        ]);

        InformeFinanciero::create($validated);

        return redirect()->route('informes.index')
            ->with('success', 'Informe financiero creado exitosamente.');
    }

    public function show(InformeFinanciero $informe)
    {
        return view('informes_financieros.show', compact('informe'));
    }

    public function edit(InformeFinanciero $informe)
    {
        return view('informes_financieros.edit', compact('informe'));
    }

    public function update(Request $request, InformeFinanciero $informe)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'ingresos_totales' => 'required|numeric|min:0',
            'gastos_totales' => 'required|numeric|min:0',
            'rentabilidad' => 'nullable|numeric',
        ]);

        $informe->update($validated);

        return redirect()->route('informes.index')
            ->with('success', 'Informe financiero actualizado exitosamente.');
    }

    public function destroy(InformeFinanciero $informe)
    {
        // Assuming we can delete informe if no constraints, adjust if needed
        $informe->delete();
        return redirect()->route('informes.index')
            ->with('success', 'Informe financiero eliminado exitosamente.');
    }
}