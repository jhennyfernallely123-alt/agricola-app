<?php

namespace App\Http\Controllers;

use App\Models\RutaEntrega;
use App\Models\Pedido;
use Illuminate\Http\Request;

class RutaEntregaController extends Controller
{
    public function index()
    {
        $rutasEntrega = RutaEntrega::with('pedido.cliente')->get();
        return view('rutas_entrega.index', compact('rutasEntrega'));
    }

    public function create()
    {
        $pedidos = Pedido::all();
        return view('rutas_entrega.create', compact('pedidos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
            'secuencia' => 'required|integer|min:1',
            'direccion' => 'required|string',
            'estado' => 'required|in:pendiente,en_proceso,completado,cancelado',
        ]);

        RutaEntrega::create($validated);

        return redirect()->route('rutas-entrega.index')
            ->with('success', 'Ruta de entrega creada exitosamente.');
    }

    public function show(RutaEntrega $rutaEntrega)
    {
        $rutaEntrega->load('pedido.cliente');
        return view('rutas_entrega.show', compact('rutaEntrega'));
    }

    public function edit(RutaEntrega $rutaEntrega)
    {
        $pedidos = Pedido::all();
        return view('rutas_entrega.edit', compact('rutaEntrega', 'pedidos'));
    }

    public function update(Request $request, RutaEntrega $rutaEntrega)
    {
        $validated = $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
            'secuencia' => 'required|integer|min:1',
            'direccion' => 'required|string',
            'estado' => 'required|in:pendiente,en_proceso,completado,cancelado',
        ]);

        $rutaEntrega->update($validated);

        return redirect()->route('rutas-entrega.index')
            ->with('success', 'Ruta de entrega actualizada exitosamente.');
    }

    public function destroy(RutaEntrega $rutaEntrega)
    {
        $rutaEntrega->delete();
        return redirect()->route('rutas-entrega.index')
            ->with('success', 'Ruta de entrega eliminada exitosamente.');
    }
}