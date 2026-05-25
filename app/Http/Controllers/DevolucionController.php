<?php

namespace App\Http\Controllers;

use App\Models\Devolucion;
use App\Models\Pedido;
use App\Models\ProductoTerminado;
use Illuminate\Http\Request;

class DevolucionController extends Controller
{
    public function index()
    {
        $devoluciones = Devolucion::with(['pedido.cliente', 'producto'])->get();
        return view('devoluciones.index', compact('devoluciones'));
    }

    public function create()
    {
        $pedidos = Pedido::all();
        $productos = ProductoTerminado::all();
        return view('devoluciones.create', compact('pedidos', 'productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:0.01',
            'motivo' => 'required|string',
            'estado' => 'required|in:pendiente,aprobado,rechazado,procesado',
        ]);

        Devolucion::create($validated);

        return redirect()->route('devoluciones.index')
            ->with('success', 'Devolución creada exitosamente.');
    }

    public function show(Devolucion $devolucion)
    {
        $devolucion->load(['pedido.cliente', 'producto']);
        return view('devoluciones.show', compact('devolucion'));
    }

    public function edit(Devolucion $devolucion)
    {
        $pedidos = Pedido::all();
        $productos = ProductoTerminado::all();
        return view('devoluciones.edit', compact('devolucion', 'pedidos', 'productos'));
    }

    public function update(Request $request, Devolucion $devolucion)
    {
        $validated = $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:0.01',
            'motivo' => 'required|string',
            'estado' => 'required|in:pendiente,aprobado,rechazado,procesado',
        ]);

        $devolucion->update($validated);

        return redirect()->route('devoluciones.index')
            ->with('success', 'Devolución actualizada exitosamente.');
    }

    public function destroy(Devolucion $devolucion)
    {
        $devolucion->delete();
        return redirect()->route('devoluciones.index')
            ->with('success', 'Devolución eliminada exitosamente.');
    }
}