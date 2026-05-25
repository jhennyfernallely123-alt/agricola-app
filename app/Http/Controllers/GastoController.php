<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class GastoController extends Controller
{
    public function index()
    {
        $gastos = Gasto::with('proveedor')->get();
        return view('gastos.index', compact('gastos'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        return view('gastos.create', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'concepto' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'proveedor_id' => 'nullable|exists:proveedores,id',
        ]);

        Gasto::create($validated);

        return redirect()->route('gastos.index')
            ->with('success', 'Gasto registrado exitosamente.');
    }

    public function show(Gasto $gasto)
    {
        $gasto->load('proveedor');
        return view('gastos.show', compact('gasto'));
    }

    public function edit(Gasto $gasto)
    {
        $proveedores = Proveedor::all();
        return view('gastos.edit', compact('gasto', 'proveedores'));
    }

    public function update(Request $request, Gasto $gasto)
    {
        $validated = $request->validate([
            'concepto' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'proveedor_id' => 'nullable|exists:proveedores,id',
        ]);

        $gasto->update($validated);

        return redirect()->route('gastos.index')
            ->with('success', 'Gasto actualizado exitosamente.');
    }

    public function destroy(Gasto $gasto)
    {
        $gasto->delete();
        return redirect()->route('gastos.index')
            ->with('success', 'Gasto eliminado exitosamente.');
    }
}