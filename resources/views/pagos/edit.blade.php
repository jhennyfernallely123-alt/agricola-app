@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-pencil"></i> Editar Pago</h1>
        <form action="{{ route('pagos.update', $pago) }}" method="POST" class="form-agricola">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="factura_id" class="form-label">Factura</label>
                <select name="factura_id" id="factura_id" class="form-select" required>
                    <option value="">Seleccione una factura</option>
                    @foreach($facturas as $factura)
                    <option value="{{ $factura->id }}" {{ $pago->factura_id == $factura->id ? 'selected' : '' }}>
                        {{ $factura->numero_factura }} - {{ $factura->pedido->cliente->nombre }}
                        (Saldo: ${{ number_format($factura->total - $factura->pagos()->where('id', '!=', $pago->id)->sum('monto'), 2) }})
                    </option>
                    @endforeach
                </select>
                @error('factura_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="monto" class="form-label">Monto</label>
                <input type="number" step="0.01" name="monto" id="monto" class="form-control" value="{{ old('monto', $pago->monto) }}" required>
                @error('monto') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $pago->fecha) }}" required>
                @error('fecha') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="metodo_pago" class="form-label">Método de Pago</label>
                <input type="text" name="metodo_pago" id="metodo_pago" class="form-control" value="{{ old('metodo_pago', $pago->metodo_pago) }}" placeholder="Ej: Efectivo, Transferencia, Tarjeta">
                @error('metodo_pago') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Actualizar Pago</button>
                <a href="{{ route('pagos.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection