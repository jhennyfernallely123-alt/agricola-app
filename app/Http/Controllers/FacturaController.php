<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Pedido;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = Factura::with('pedido.cliente')->get();
        return view('facturas.index', compact('facturas'));
    }

    public function create()
    {
        $pedidos = Pedido::doesntHave('factura')->get(); // Only pedidos without factura
        return view('facturas.create', compact('pedidos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pedido_id' => 'required|exists:pedidos,id|unique:facturas,pedido_id',
            'numero_factura' => 'required|string|max:255|unique:facturas,numero_factura',
            'subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'estado_pago' => 'required|in:pendiente,pagado,parcial',
        ]);

        Factura::create($validated);

        return redirect()->route('facturas.index')
            ->with('success', 'Factura creada exitosamente.');
    }

    public function show(Factura $factura)
    {
        $factura->load('pedido.cliente', 'pagos');
        return view('facturas.show', compact('factura'));
    }

    public function edit(Factura $factura)
    {
        $pedidos = Pedido::doesntHave('factura')->orWhere('id', $factura->pedido_id)->get();
        return view('facturas.edit', compact('factura', 'pedidos'));
    }

    public function update(Request $request, Factura $factura)
    {
        $validated = $request->validate([
            'pedido_id' => 'required|exists:pedidos,id|unique:facturas,pedido_id,'.$factura->id,
            'numero_factura' => 'required|string|max:255|unique:facturas,numero_factura,'.$factura->id,
            'subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'estado_pago' => 'required|in:pendiente,pagado,parcial',
        ]);

        $factura->update($validated);

        return redirect()->route('facturas.index')
            ->with('success', 'Factura actualizada exitosamente.');
    }

    public function destroy(Factura $factura)
    {
        if ($factura->pagos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar la factura porque tiene pagos asociados.');
        }

        $factura->delete();
        return redirect()->route('facturas.index')
            ->with('success', 'Factura eliminada exitosamente.');
    }
}