<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Factura;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with('factura.pedido.cliente')->get();
        return view('pagos.index', compact('pagos'));
    }

    public function create()
    {
        $facturas = Factura::where('estado_pago', '!=', 'pagado')->get(); // Only facturas not fully paid
        return view('pagos.create', compact('facturas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'factura_id' => 'required|exists:facturas,id',
            'monto' => 'required|numeric|min:0.01',
            'fecha' => 'required|date',
            'metodo_pago' => 'nullable|string|max:255',
        ]);

        // Validate that the monto does not exceed the remaining amount to pay
        $factura = Factura::find($validated['factura_id']);
        $totalPagado = $factura->pagos()->sum('monto');
        $restante = $factura->total - $totalPagado;

        if ($validated['monto'] > $restante) {
            return back()->withInput()
                ->withErrors(['monto' => "El monto excede el saldo pendiente de la factura. Saldo pendiente: $" . number_format($restante, 2)]);
        }

        Pago::create($validated);

        return redirect()->route('pagos.index')
            ->with('success', 'Pago registrado exitosamente.');
    }

    public function show(Pago $pago)
    {
        $pago->load('factura.pedido.cliente');
        return view('pagos.show', compact('pago'));
    }

    public function edit(Pago $pago)
    {
        $facturas = Factura::where('estado_pago', '!=', 'pagado')
            ->orWhere('id', $pago->factura_id)
            ->get();
        return view('pagos.edit', compact('pago', 'facturas'));
    }

    public function update(Request $request, Pago $pago)
    {
        $validated = $request->validate([
            'factura_id' => 'required|exists:facturas,id',
            'monto' => 'required|numeric|min:0.01',
            'fecha' => 'required|date',
            'metodo_pago' => 'nullable|string|max:255',
        ]);

        // Validate that the monto does not exceed the remaining amount to pay (excluding this pago)
        $factura = Factura::find($validated['factura_id']);
        $totalPagado = $factura->pagos()->where('id', '!=', $pago->id)->sum('monto');
        $restante = $factura->total - $totalPagado;

        if ($validated['monto'] > $restante) {
            return back()->withInput()
                ->withErrors(['monto' => "El monto excede el saldo pendiente de la factura. Saldo pendiente: $" . number_format($restante, 2)]);
        }

        $pago->update($validated);

        return redirect()->route('pagos.index')
            ->with('success', 'Pago actualizado exitosamente.');
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();
        return redirect()->route('pagos.index')
            ->with('success', 'Pago eliminado exitosamente.');
    }
}