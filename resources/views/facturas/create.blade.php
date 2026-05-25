@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-file-earmark-plus"></i> Nueva Factura</h1>
        <form action="{{ route('facturas.store') }}" method="POST" class="form-agricola">
            @csrf
            <div class="mb-3">
                <label for="pedido_id" class="form-label">Pedido</label>
                <select name="pedido_id" id="pedido_id" class="form-select" required>
                    <option value="">Seleccione un pedido</option>
                    @foreach($pedidos as $pedido)
                    <option value="{{ $pedido->id }}">
                        #{{ $pedido->id }} - {{ $pedido->cliente->nombre }} ({{ $pedido->fecha }})
                    </option>
                    @endforeach
                </select>
                @error('pedido_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="numero_factura" class="form-label">Número de Factura</label>
                <input type="text" name="numero_factura" id="numero_factura" class="form-control" value="{{ old('numero_factura') }}" required>
                @error('numero_factura') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="subtotal" class="form-label">Subtotal</label>
                <input type="number" step="0.01" name="subtotal" id="subtotal" class="form-control" value="{{ old('subtotal') }}" required>
                @error('subtotal') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="total" class="form-label">Total</label>
                <input type="number" step="0.01" name="total" id="total" class="form-control" value="{{ old('total') }}" required>
                @error('total') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="estado_pago" class="form-label">Estado de Pago</label>
                <select name="estado_pago" id="estado_pago" class="form-select" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="parcial">Parcial</option>
                    <option value="pagado">Pagado</option>
                </select>
                @error('estado_pago') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Crear Factura</button>
                <a href="{{ route('facturas.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection