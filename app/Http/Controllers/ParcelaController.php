<?php

namespace App\Http\Controllers;

use App\Models\Parcela;
use Illuminate\Http\Request;

class ParcelaController extends Controller
{
    public function index()
    {
        $parcelas = Parcela::withCount('cultivos')->get();
        return view('parcelas.index', compact('parcelas'));
    }

    public function create()
    {
        return view('parcelas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'area' => 'required|numeric|min:0',
            'historial_uso' => 'nullable|string',
            'analisis_suelo' => 'nullable|string',
            'potencial_productivo' => 'nullable|string|max:255',
        ]);

        Parcela::create($validated);

        return redirect()->route('parcelas.index')
            ->with('success', 'Parcela creada exitosamente.');
    }

    public function show(Parcela $parcela)
    {
        $parcela->load('cultivos');
        return view('parcelas.show', compact('parcela'));
    }

    public function edit(Parcela $parcela)
    {
        return view('parcelas.edit', compact('parcela'));
    }

    public function update(Request $request, Parcela $parcela)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'area' => 'required|numeric|min:0',
            'historial_uso' => 'nullable|string',
            'analisis_suelo' => 'nullable|string',
            'potencial_productivo' => 'nullable|string|max:255',
        ]);

        $parcela->update($validated);

        return redirect()->route('parcelas.index')
            ->with('success', 'Parcela actualizada exitosamente.');
    }

    public function destroy(Parcela $parcela)
    {
        if ($parcela->cultivos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar la parcela porque tiene cultivos asociados.');
        }

        $parcela->delete();
        return redirect()->route('parcelas.index')
            ->with('success', 'Parcela eliminada exitosamente.');
    }
}