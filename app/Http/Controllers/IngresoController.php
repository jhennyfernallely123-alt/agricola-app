<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\Pedido;
use Illuminate\Http\Request;

class IngresoController extends Controller
{
    public function index()
    {
        $ingresos = Ingreso::with('pedido')->get();
        return view('ingresos.index', compact('ingresos'));
    }

    public function create()
    {
        $pedidos = Pedido::all();
        return view('ingresos.create', compact('pedidos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fuente' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'pedido_id' => 'nullable|exists:pedidos,id',
        ]);

        Ingreso::create($validated);

        return redirect()->route('ingresos.index')
            ->with('success', 'Ingreso registrado exitosamente.');
    }

    public function show(Ingreso $ingreso)
    {
        $ingreso->load('pedido');
        return view('ingresos.show', compact('ingreso'));
    }

    public function edit(Ingreso $ingreso)
    {
        $pedidos = Pedido::all();
        return view('ingresos.edit', compact('ingreso', 'pedidos'));
    }

    public function update(Request $request, Ingreso $ingreso)
    {
        $validated = $request->validate([
            'fuente' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'pedido_id' => 'nullable|exists:pedidos,id',
        ]);

        $ingreso->update($validated);

        return redirect()->route('ingresos.index')
            ->with('success', 'Ingreso actualizado exitosamente.');
    }

    public function destroy(Ingreso $ingreso)
    {
        $ingreso->delete();
        return redirect()->route('ingresos.index')
            ->with('success', 'Ingreso eliminado exitosamente.');
    }
}